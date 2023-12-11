(function ($) {
    "use strict";
    var $window = $(window);
    var $body = $('body');


    //https://github.com/silentmatt/expr-eval
    function MathParser() {

        /*!
         Based on ndef.parser, by Raphael Graf(r@undefined.ch)
         http://www.undefined.ch/mparser/index.html
         
         Ported to JavaScript and modified by Matthew Crumley (email@matthewcrumley.com, http://silentmatt.com/)
         
         You are free to use and modify this code in anyway you find useful. Please leave this comment in the code
         to acknowledge its original source. If you feel like it, I enjoy hearing about projects that use my code,
         but don't feel like you have to let me know or ask permission.
         */

        function indexOf(array, obj) {
            for (var i = 0; i < array.length; i++) {
                if (array[i] === obj) {
                    return i;
                }
            }
            return -1;
        }

        var INUMBER = 'INUMBER';
        var IOP1 = 'IOP1';
        var IOP2 = 'IOP2';
        var IOP3 = 'IOP3';
        var IVAR = 'IVAR';
        var IFUNCALL = 'IFUNCALL';
        var IEXPR = 'IEXPR';
        var IMEMBER = 'IMEMBER';

        function Instruction(type, value) {
            this.type = type;
            this.value = (value !== undefined && value !== null) ? value : 0;
        }

        Instruction.prototype.toString = function () {
            switch (this.type) {
                case INUMBER:
                case IOP1:
                case IOP2:
                case IOP3:
                case IVAR:
                    return this.value;
                case IFUNCALL:
                    return 'CALL ' + this.value;
                case IMEMBER:
                    return '.' + this.value;
                default:
                    return 'Invalid Instruction';
            }
        };

        function Expression(tokens, parser) {
            this.tokens = tokens;
            this.parser = parser;
            this.unaryOps = parser.unaryOps;
            this.binaryOps = parser.binaryOps;
            this.ternaryOps = parser.ternaryOps;
            this.functions = parser.functions;
        }

        function escapeValue(v) {
            if (typeof v === 'string') {
                return JSON.stringify(v).replace(/\u2028/g, '\\u2028').replace(/\u2029/g, '\\u2029');
            }
            return v;
        }

        function simplify(tokens, unaryOps, binaryOps, ternaryOps, values) {
            var nstack = [];
            var newexpression = [];
            var n1, n2, n3;
            var f;
            for (var i = 0, L = tokens.length; i < L; i++) {
                var item = tokens[i];
                var type = item.type;
                if (type === INUMBER) {
                    nstack.push(item);
                } else if (type === IVAR && values.hasOwnProperty(item.value)) {
                    item = new Instruction(INUMBER, values[item.value]);
                    nstack.push(item);
                } else if (type === IOP2 && nstack.length > 1) {
                    n2 = nstack.pop();
                    n1 = nstack.pop();
                    f = binaryOps[item.value];
                    item = new Instruction(INUMBER, f(n1.value, n2.value));
                    nstack.push(item);
                } else if (type === IOP3 && nstack.length > 2) {
                    n3 = nstack.pop();
                    n2 = nstack.pop();
                    n1 = nstack.pop();
                    if (item.value === '?') {
                        nstack.push(n1.value ? n2.value : n3.value);
                    } else {
                        f = ternaryOps[item.value];
                        item = new Instruction(INUMBER, f(n1.value, n2.value, n3.value));
                        nstack.push(item);
                    }
                } else if (type === IOP1 && nstack.length > 0) {
                    n1 = nstack.pop();
                    f = unaryOps[item.value];
                    item = new Instruction(INUMBER, f(n1.value));
                    nstack.push(item);
                } else if (type === IEXPR) {
                    while (nstack.length > 0) {
                        newexpression.push(nstack.shift());
                    }
                    newexpression.push(new Instruction(IEXPR, simplify(item.value, unaryOps, binaryOps, ternaryOps, values)));
                } else if (type === IMEMBER && nstack.length > 0) {
                    n1 = nstack.pop();
                    nstack.push(new Instruction(INUMBER, n1.value[item.value]));
                } else {
                    while (nstack.length > 0) {
                        newexpression.push(nstack.shift());
                    }
                    newexpression.push(item);
                }
            }
            while (nstack.length > 0) {
                newexpression.push(nstack.shift());
            }
            return newexpression;
        }

        Expression.prototype.simplify = function (values) {
            values = values || {};
            return new Expression(simplify(this.tokens, this.unaryOps, this.binaryOps, this.ternaryOps, values), this.parser);
        };

        function substitute(tokens, variable, expr) {
            var newexpression = [];
            for (var i = 0, L = tokens.length; i < L; i++) {
                var item = tokens[i];
                var type = item.type;
                if (type === IVAR && item.value === variable) {
                    for (var j = 0; j < expr.tokens.length; j++) {
                        var expritem = expr.tokens[j];
                        var replitem;
                        if (expritem.type === IOP1) {
                            replitem = unaryInstruction(expritem.value);
                        } else if (expritem.type === IOP2) {
                            replitem = binaryInstruction(expritem.value);
                        } else if (expritem.type === IOP3) {
                            replitem = ternaryInstruction(expritem.value);
                        } else {
                            replitem = new Instruction(expritem.type, expritem.value);
                        }
                        newexpression.push(replitem);
                    }
                } else if (type === IEXPR) {
                    newexpression.push(new Instruction(IEXPR, substitute(item.value, variable, expr)));
                } else {
                    newexpression.push(item);
                }
            }
            return newexpression;
        }

        Expression.prototype.substitute = function (variable, expr) {
            if (!(expr instanceof Expression)) {
                expr = this.parser.parse(String(expr));
            }

            return new Expression(substitute(this.tokens, variable, expr), this.parser);
        };

        function evaluate(tokens, expr, values) {
            var nstack = [];
            var n1, n2, n3;
            var f;
            for (var i = 0, L = tokens.length; i < L; i++) {
                var item = tokens[i];
                var type = item.type;
                if (type === INUMBER) {
                    nstack.push(item.value);
                } else if (type === IOP2) {
                    n2 = nstack.pop();
                    n1 = nstack.pop();
                    f = expr.binaryOps[item.value];
                    nstack.push(f(n1, n2));
                } else if (type === IOP3) {
                    n3 = nstack.pop();
                    n2 = nstack.pop();
                    n1 = nstack.pop();
                    if (item.value === '?') {
                        nstack.push(evaluate(n1 ? n2 : n3, expr, values));
                    } else {
                        f = expr.ternaryOps[item.value];
                        nstack.push(f(n1, n2, n3));
                    }
                } else if (type === IVAR) {
                    if (item.value in expr.functions) {
                        nstack.push(expr.functions[item.value]);
                    } else {
                        var v = values[item.value];
                        if (v !== undefined) {
                            nstack.push(v);
                        } else {
                            throw new Error('undefined variable: ' + item.value);
                        }
                    }
                } else if (type === IOP1) {
                    n1 = nstack.pop();
                    f = expr.unaryOps[item.value];
                    nstack.push(f(n1));
                } else if (type === IFUNCALL) {
                    var argCount = item.value;
                    var args = [];
                    while (argCount-- > 0) {
                        args.unshift(nstack.pop());
                    }
                    f = nstack.pop();
                    if (f.apply && f.call) {
                        nstack.push(f.apply(undefined, args));
                    } else {
                        throw new Error(f + ' is not a function');
                    }
                } else if (type === IEXPR) {
                    nstack.push(item.value);
                } else if (type === IMEMBER) {
                    n1 = nstack.pop();
                    nstack.push(n1[item.value]);
                } else {
                    throw new Error('invalid Expression');
                }
            }
            if (nstack.length > 1) {
                throw new Error('invalid Expression (parity)');
            }
            return nstack[0];
        }

        Expression.prototype.evaluate = function (values) {
            values = values || {};
            return evaluate(this.tokens, this, values);
        };

        function expressionToString(tokens, toJS) {
            var nstack = [];
            var n1, n2, n3;
            var f;
            for (var i = 0, L = tokens.length; i < L; i++) {
                var item = tokens[i];
                var type = item.type;
                if (type === INUMBER) {
                    if (typeof item.value === 'number' && item.value < 0) {
                        nstack.push('(' + item.value + ')');
                    } else {
                        nstack.push(escapeValue(item.value));
                    }
                } else if (type === IOP2) {
                    n2 = nstack.pop();
                    n1 = nstack.pop();
                    f = item.value;
                    if (toJS) {
                        if (f === '^') {
                            nstack.push('Math.pow(' + n1 + ', ' + n2 + ')');
                        } else if (f === 'and') {
                            nstack.push('(!!' + n1 + ' && !!' + n2 + ')');
                        } else if (f === 'or') {
                            nstack.push('(!!' + n1 + ' || !!' + n2 + ')');
                        } else if (f === '||') {
                            nstack.push('(String(' + n1 + ') + String(' + n2 + '))');
                        } else if (f === '==') {
                            nstack.push('(' + n1 + ' === ' + n2 + ')');
                        } else if (f === '!=') {
                            nstack.push('(' + n1 + ' !== ' + n2 + ')');
                        } else {
                            nstack.push('(' + n1 + ' ' + f + ' ' + n2 + ')');
                        }
                    } else {
                        nstack.push('(' + n1 + ' ' + f + ' ' + n2 + ')');
                    }
                } else if (type === IOP3) {
                    n3 = nstack.pop();
                    n2 = nstack.pop();
                    n1 = nstack.pop();
                    f = item.value;
                    if (f === '?') {
                        nstack.push('(' + n1 + ' ? ' + n2 + ' : ' + n3 + ')');
                    } else {
                        throw new Error('invalid Expression');
                    }
                } else if (type === IVAR) {
                    nstack.push(item.value);
                } else if (type === IOP1) {
                    n1 = nstack.pop();
                    f = item.value;
                    if (f === '-' || f === '+') {
                        nstack.push('(' + f + n1 + ')');
                    } else if (toJS) {
                        if (f === 'not') {
                            nstack.push('(' + '!' + n1 + ')');
                        } else if (f === '!') {
                            nstack.push('fac(' + n1 + ')');
                        } else {
                            nstack.push(f + '(' + n1 + ')');
                        }
                    } else if (f === '!') {
                        nstack.push('(' + n1 + '!)');
                    } else {
                        nstack.push('(' + f + ' ' + n1 + ')');
                    }
                } else if (type === IFUNCALL) {
                    var argCount = item.value;
                    var args = [];
                    while (argCount-- > 0) {
                        args.unshift(nstack.pop());
                    }
                    f = nstack.pop();
                    nstack.push(f + '(' + args.join(', ') + ')');
                } else if (type === IMEMBER) {
                    n1 = nstack.pop();
                    nstack.push(n1 + '.' + item.value);
                } else if (type === IEXPR) {
                    nstack.push('(' + expressionToString(item.value, toJS) + ')');
                } else {
                    throw new Error('invalid Expression');
                }
            }
            if (nstack.length > 1) {
                throw new Error('invalid Expression (parity)');
            }
            return nstack[0];
        }

        Expression.prototype.toString = function () {
            return expressionToString(this.tokens, false);
        };

        function getSymbols(tokens, symbols) {
            for (var i = 0, L = tokens.length; i < L; i++) {
                var item = tokens[i];
                if (item.type === IVAR && (indexOf(symbols, item.value) === -1)) {
                    symbols.push(item.value);
                } else if (item.type === IEXPR) {
                    getSymbols(item.value, symbols);
                }
            }
        }

        Expression.prototype.symbols = function () {
            var vars = [];
            getSymbols(this.tokens, vars);
            return vars;
        };

        Expression.prototype.variables = function () {
            var vars = [];
            getSymbols(this.tokens, vars);
            var functions = this.functions;
            return vars.filter(function (name) {
                return !(name in functions);
            });
        };

        Expression.prototype.toJSFunction = function (param, variables) {
            var expr = this;
            var f = new Function(param, 'with(this.functions) with (this.ternaryOps) with (this.binaryOps) with (this.unaryOps) { return ' + expressionToString(this.simplify(variables).tokens, true) + '; }'); // eslint-disable-line no-new-func
            return function () {
                return f.apply(expr, arguments);
            };
        };

        function add(a, b) {
            return Number(a) + Number(b);
        }
        function sub(a, b) {
            return a - b;
        }
        function mul(a, b) {
            return a * b;
        }
        function div(a, b) {
            return a / b;
        }
        function mod(a, b) {
            return a % b;
        }
        function concat(a, b) {
            return '' + a + b;
        }
        function equal(a, b) {
            return a === b;
        }
        function notEqual(a, b) {
            return a !== b;
        }
        function greaterThan(a, b) {
            return a > b;
        }
        function lessThan(a, b) {
            return a < b;
        }
        function greaterThanEqual(a, b) {
            return a >= b;
        }
        function lessThanEqual(a, b) {
            return a <= b;
        }
        function andOperator(a, b) {
            return Boolean(a && b);
        }
        function orOperator(a, b) {
            return Boolean(a || b);
        }
        function sinh(a) {
            return ((Math.exp(a) - Math.exp(-a)) / 2);
        }
        function cosh(a) {
            return ((Math.exp(a) + Math.exp(-a)) / 2);
        }
        function tanh(a) {
            if (a === Infinity)
                return 1;
            if (a === -Infinity)
                return -1;
            return (Math.exp(a) - Math.exp(-a)) / (Math.exp(a) + Math.exp(-a));
        }
        function asinh(a) {
            if (a === -Infinity)
                return a;
            return Math.log(a + Math.sqrt(a * a + 1));
        }
        function acosh(a) {
            return Math.log(a + Math.sqrt(a * a - 1));
        }
        function atanh(a) {
            return (Math.log((1 + a) / (1 - a)) / 2);
        }
        function log10(a) {
            return Math.log(a) * Math.LOG10E;
        }
        function neg(a) {
            return -a;
        }
        function not(a) {
            return !a;
        }
        function trunc(a) {
            return a < 0 ? Math.ceil(a) : Math.floor(a);
        }
        function random(a) {
            return Math.random() * (a || 1);
        }
        function factorial(a) { // a!
            return gamma(a + 1);
        }
        function stringLength(s) {
            return String(s).length;
        }

        function hypot() {
            var sum = 0;
            var larg = 0;
            for (var i = 0, L = arguments.length; i < L; i++) {
                var arg = Math.abs(arguments[i]);
                var div;
                if (larg < arg) {
                    div = larg / arg;
                    sum = sum * div * div + 1;
                    larg = arg;
                } else if (arg > 0) {
                    div = arg / larg;
                    sum += div * div;
                } else {
                    sum += arg;
                }
            }
            return larg === Infinity ? Infinity : larg * Math.sqrt(sum);
        }

        function condition(cond, yep, nope) {
            return cond ? yep : nope;
        }

        function isInteger(value) {
            return isFinite(value) && (value === Math.round(value));
        }

        var GAMMA_G = 4.7421875;
        var GAMMA_P = [
            0.99999999999999709182,
            57.156235665862923517, -59.597960355475491248,
            14.136097974741747174, -0.49191381609762019978,
            0.33994649984811888699e-4,
            0.46523628927048575665e-4, -0.98374475304879564677e-4,
            0.15808870322491248884e-3, -0.21026444172410488319e-3,
            0.21743961811521264320e-3, -0.16431810653676389022e-3,
            0.84418223983852743293e-4, -0.26190838401581408670e-4,
            0.36899182659531622704e-5
        ];

// Gamma function from math.js
        function gamma(n) {
            var t, x;

            if (isInteger(n)) {
                if (n <= 0) {
                    return isFinite(n) ? Infinity : NaN;
                }

                if (n > 171) {
                    return Infinity; // Will overflow
                }

                var value = n - 2;
                var res = n - 1;
                while (value > 1) {
                    res *= value;
                    value--;
                }

                if (res === 0) {
                    res = 1; // 0! is per definition 1
                }

                return res;
            }

            if (n < 0.5) {
                return Math.PI / (Math.sin(Math.PI * n) * gamma(1 - n));
            }

            if (n >= 171.35) {
                return Infinity; // will overflow
            }

            if (n > 85.0) { // Extended Stirling Approx
                var twoN = n * n;
                var threeN = twoN * n;
                var fourN = threeN * n;
                var fiveN = fourN * n;
                return Math.sqrt(2 * Math.PI / n) * Math.pow((n / Math.E), n) *
                        (1 + 1 / (12 * n) + 1 / (288 * twoN) - 139 / (51840 * threeN) -
                                571 / (2488320 * fourN) + 163879 / (209018880 * fiveN) +
                                5246819 / (75246796800 * fiveN * n));
            }

            --n;
            x = GAMMA_P[0];
            for (var i = 1; i < GAMMA_P.length; ++i) {
                x += GAMMA_P[i] / (n + i);
            }

            t = n + GAMMA_G + 0.5;
            return Math.sqrt(2 * Math.PI) * Math.pow(t, n + 0.5) * Math.exp(-t) * x;
        }

        var TEOF = 'TEOF';
        var TOP = 'TOP';
        var TNUMBER = 'TNUMBER';
        var TSTRING = 'TSTRING';
        var TPAREN = 'TPAREN';
        var TCOMMA = 'TCOMMA';
        var TNAME = 'TNAME';

        function Token(type, value, line, column) {
            this.type = type;
            this.value = value;
            this.line = line;
            this.column = column;
        }

        Token.prototype.toString = function () {
            return this.type + ': ' + this.value;
        };

        function TokenStream(expression, unaryOps, binaryOps, ternaryOps, consts) {
            this.pos = 0;
            this.line = 0;
            this.column = 0;
            this.current = null;
            this.unaryOps = unaryOps;
            this.binaryOps = binaryOps;
            this.ternaryOps = ternaryOps;
            this.consts = consts;
            this.expression = expression;
            this.savedPosition = 0;
            this.savedCurrent = null;
            this.savedLine = 0;
            this.savedColumn = 0;
        }

        TokenStream.prototype.newToken = function (type, value, line, column) {
            return new Token(type, value, line != null ? line : this.line, column != null ? column : this.column);
        };

        TokenStream.prototype.save = function () {
            this.savedPosition = this.pos;
            this.savedCurrent = this.current;
            this.savedLine = this.line;
            this.savedColumn = this.column;
        };

        TokenStream.prototype.restore = function () {
            this.pos = this.savedPosition;
            this.current = this.savedCurrent;
            this.line = this.savedLine;
            this.column = this.savedColumn;
        };

        TokenStream.prototype.next = function () {
            if (this.pos >= this.expression.length) {
                return this.newToken(TEOF, 'EOF');
            }

            if (this.isWhitespace() || this.isComment()) {
                return this.next();
            } else if (this.isNumber() ||
                    this.isOperator() ||
                    this.isString() ||
                    this.isParen() ||
                    this.isComma() ||
                    this.isNamedOp() ||
                    this.isConst() ||
                    this.isName()) {
                return this.current;
            } else {
                this.parseError('Unknown character "' + this.expression.charAt(this.pos) + '"');
            }
        };

        TokenStream.prototype.isString = function () {
            var r = false;
            var startLine = this.line;
            var startColumn = this.column;
            var startPos = this.pos;
            var quote = this.expression.charAt(startPos);

            if (quote === '\'' || quote === '"') {
                this.pos++;
                this.column++;
                var index = this.expression.indexOf(quote, startPos + 1);
                while (index >= 0 && this.pos < this.expression.length) {
                    this.pos = index + 1;
                    if (this.expression.charAt(index - 1) !== '\\') {
                        var rawString = this.expression.substring(startPos + 1, index);
                        this.current = this.newToken(TSTRING, this.unescape(rawString), startLine, startColumn);
                        var newLine = rawString.indexOf('\n');
                        var lastNewline = -1;
                        while (newLine >= 0) {
                            this.line++;
                            this.column = 0;
                            lastNewline = newLine;
                            newLine = rawString.indexOf('\n', newLine + 1);
                        }
                        this.column += rawString.length - lastNewline;
                        r = true;
                        break;
                    }
                    index = this.expression.indexOf(quote, index + 1);
                }
            }
            return r;
        };

        TokenStream.prototype.isParen = function () {
            var char = this.expression.charAt(this.pos);
            if (char === '(' || char === ')') {
                this.current = this.newToken(TPAREN, char);
                this.pos++;
                this.column++;
                return true;
            }
            return false;
        };

        TokenStream.prototype.isComma = function () {
            var char = this.expression.charAt(this.pos);
            if (char === ',') {
                this.current = this.newToken(TCOMMA, ',');
                this.pos++;
                this.column++;
                return true;
            }
            return false;
        };

        TokenStream.prototype.isConst = function () {
            var startPos = this.pos;
            var i = startPos;
            for (; i < this.expression.length; i++) {
                var c = this.expression.charAt(i);
                if (c.toUpperCase() === c.toLowerCase()) {
                    if (i === this.pos || (c !== '_' && c !== '.' && (c < '0' || c > '9'))) {
                        break;
                    }
                }
            }
            if (i > startPos) {
                var str = this.expression.substring(startPos, i);
                if (str in this.consts) {
                    this.current = this.newToken(TNUMBER, this.consts[str]);
                    this.pos += str.length;
                    this.column += str.length;
                    return true;
                }
            }
            return false;
        };

        TokenStream.prototype.isNamedOp = function () {
            var startPos = this.pos;
            var i = startPos;
            for (; i < this.expression.length; i++) {
                var c = this.expression.charAt(i);
                if (c.toUpperCase() === c.toLowerCase()) {
                    if (i === this.pos || (c !== '_' && (c < '0' || c > '9'))) {
                        break;
                    }
                }
            }
            if (i > startPos) {
                var str = this.expression.substring(startPos, i);
                if (str in this.binaryOps || str in this.unaryOps || str in this.ternaryOps) {
                    this.current = this.newToken(TOP, str);
                    this.pos += str.length;
                    this.column += str.length;
                    return true;
                }
            }
            return false;
        };

        TokenStream.prototype.isName = function () {
            var startPos = this.pos;
            var i = startPos;
            for (; i < this.expression.length; i++) {
                var c = this.expression.charAt(i);
                if (c.toUpperCase() === c.toLowerCase()) {
                    if (i === this.pos || (c !== '_' && (c < '0' || c > '9'))) {
                        break;
                    }
                }
            }
            if (i > startPos) {
                var str = this.expression.substring(startPos, i);
                this.current = this.newToken(TNAME, str);
                this.pos += str.length;
                this.column += str.length;
                return true;
            }
            return false;
        };

        TokenStream.prototype.isWhitespace = function () {
            var r = false;
            var char = this.expression.charAt(this.pos);
            while (char === ' ' || char === '\t' || char === '\n' || char === '\r') {
                r = true;
                this.pos++;
                this.column++;
                if (char === '\n') {
                    this.line++;
                    this.column = 0;
                }
                if (this.pos >= this.expression.length) {
                    break;
                }
                char = this.expression.charAt(this.pos);
            }
            return r;
        };

        var codePointPattern = /^[0-9a-f]{4}$/i;

        TokenStream.prototype.unescape = function (v) {
            var index = v.indexOf('\\');
            if (index < 0) {
                return v;
            }

            var buffer = v.substring(0, index);
            while (index >= 0) {
                var c = v.charAt(++index);
                switch (c) {
                    case '\'':
                        buffer += '\'';
                        break;
                    case '"':
                        buffer += '"';
                        break;
                    case '\\':
                        buffer += '\\';
                        break;
                    case '/':
                        buffer += '/';
                        break;
                    case 'b':
                        buffer += '\b';
                        break;
                    case 'f':
                        buffer += '\f';
                        break;
                    case 'n':
                        buffer += '\n';
                        break;
                    case 'r':
                        buffer += '\r';
                        break;
                    case 't':
                        buffer += '\t';
                        break;
                    case 'u':
                        // interpret the following 4 characters as the hex of the unicode code point
                        var codePoint = v.substring(index + 1, index + 5);
                        if (!codePointPattern.test(codePoint)) {
                            this.parseError('Illegal escape sequence: \\u' + codePoint);
                        }
                        buffer += String.fromCharCode(parseInt(codePoint, 16));
                        index += 4;
                        break;
                    default:
                        throw this.parseError('Illegal escape sequence: "\\' + c + '"');
                }
                ++index;
                var backslash = v.indexOf('\\', index);
                buffer += v.substring(index, backslash < 0 ? v.length : backslash);
                index = backslash;
            }

            return buffer;
        };

        TokenStream.prototype.isComment = function () {
            var char = this.expression.charAt(this.pos);
            if (char === '/' && this.expression.charAt(this.pos + 1) === '*') {
                var startPos = this.pos;
                this.pos = this.expression.indexOf('*/', this.pos) + 2;
                if (this.pos === 1) {
                    this.pos = this.expression.length;
                }
                var comment = this.expression.substring(startPos, this.pos);
                var newline = comment.indexOf('\n');
                while (newline >= 0) {
                    this.line++;
                    this.column = comment.length - newline;
                    newline = comment.indexOf('\n', newline + 1);
                }
                return true;
            }
            return false;
        };

        TokenStream.prototype.isNumber = function () {
            var valid = false;
            var pos = this.pos;
            var startPos = pos;
            var resetPos = pos;
            var column = this.column;
            var resetColumn = column;
            var foundDot = false;
            var foundDigits = false;
            var char;

            while (pos < this.expression.length) {
                char = this.expression.charAt(pos);
                if ((char >= '0' && char <= '9') || (!foundDot && char === '.')) {
                    if (char === '.') {
                        foundDot = true;
                    } else {
                        foundDigits = true;
                    }
                    pos++;
                    column++;
                    valid = foundDigits;
                } else {
                    break;
                }
            }

            if (valid) {
                resetPos = pos;
                resetColumn = column;
            }

            if (char === 'e' || char === 'E') {
                pos++;
                column++;
                var acceptSign = true;
                var validExponent = false;
                while (pos < this.expression.length) {
                    char = this.expression.charAt(pos);
                    if (acceptSign && (char === '+' || char === '-')) {
                        acceptSign = false;
                    } else if (char >= '0' && char <= '9') {
                        validExponent = true;
                        acceptSign = false;
                    } else {
                        break;
                    }
                    pos++;
                    column++;
                }

                if (!validExponent) {
                    pos = resetPos;
                    column = resetColumn;
                }
            }

            if (valid) {
                this.current = this.newToken(TNUMBER, parseFloat(this.expression.substring(startPos, pos)));
                this.pos = pos;
                this.column = column;
            } else {
                this.pos = resetPos;
                this.column = resetColumn;
            }
            return valid;
        };

        TokenStream.prototype.isOperator = function () {
            var char = this.expression.charAt(this.pos);

            if (char === '+' || char === '-' || char === '*' || char === '/' || char === '%' || char === '^' || char === '?' || char === ':' || char === '.') {
                this.current = this.newToken(TOP, char);
            } else if (char === '∙' || char === '•') {
                this.current = this.newToken(TOP, '*');
            } else if (char === '>') {
                if (this.expression.charAt(this.pos + 1) === '=') {
                    this.current = this.newToken(TOP, '>=');
                    this.pos++;
                    this.column++;
                } else {
                    this.current = this.newToken(TOP, '>');
                }
            } else if (char === '<') {
                if (this.expression.charAt(this.pos + 1) === '=') {
                    this.current = this.newToken(TOP, '<=');
                    this.pos++;
                    this.column++;
                } else {
                    this.current = this.newToken(TOP, '<');
                }
            } else if (char === '|') {
                if (this.expression.charAt(this.pos + 1) === '|') {
                    this.current = this.newToken(TOP, '||');
                    this.pos++;
                    this.column++;
                } else {
                    return false;
                }
            } else if (char === '=') {
                if (this.expression.charAt(this.pos + 1) === '=') {
                    this.current = this.newToken(TOP, '==');
                    this.pos++;
                    this.column++;
                } else {
                    return false;
                }
            } else if (char === '!') {
                if (this.expression.charAt(this.pos + 1) === '=') {
                    this.current = this.newToken(TOP, '!=');
                    this.pos++;
                    this.column++;
                } else {
                    this.current = this.newToken(TOP, char);
                }
            } else {
                return false;
            }
            this.pos++;
            this.column++;
            return true;
        };

        TokenStream.prototype.parseError = function (msg) {
            throw new Error('parse error [' + (this.line + 1) + ':' + (this.column + 1) + ']: ' + msg);
        };

        function unaryInstruction(value) {
            return new Instruction(IOP1, value);
        }

        function binaryInstruction(value) {
            return new Instruction(IOP2, value);
        }

        function ternaryInstruction(value) {
            return new Instruction(IOP3, value);
        }

        function ParserState(parser, tokenStream) {
            this.parser = parser;
            this.tokens = tokenStream;
            this.current = null;
            this.nextToken = null;
            this.next();
            this.savedCurrent = null;
            this.savedNextToken = null;
        }

        ParserState.prototype.next = function () {
            this.current = this.nextToken;
            return (this.nextToken = this.tokens.next());
        };

        ParserState.prototype.tokenMatches = function (token, value) {
            if (typeof value === 'undefined') {
                return true;
            } else if (Array.isArray(value)) {
                return indexOf(value, token.value) >= 0;
            } else if (typeof value === 'function') {
                return value(token);
            } else {
                return token.value === value;
            }
        };

        ParserState.prototype.save = function () {
            this.savedCurrent = this.current;
            this.savedNextToken = this.nextToken;
            this.tokens.save();
        };

        ParserState.prototype.restore = function () {
            this.tokens.restore();
            this.current = this.savedCurrent;
            this.nextToken = this.savedNextToken;
        };

        ParserState.prototype.accept = function (type, value) {
            if (this.nextToken.type === type && this.tokenMatches(this.nextToken, value)) {
                this.next();
                return true;
            }
            return false;
        };

        ParserState.prototype.expect = function (type, value) {
            if (!this.accept(type, value)) {
                throw new Error('parse error [' + this.tokens.line + ':' + this.tokens.column + ']: Expected ' + (value || type));
            }
        };

        ParserState.prototype.parseAtom = function (instr) {
            if (this.accept(TNAME)) {
                instr.push(new Instruction(IVAR, this.current.value));
            } else if (this.accept(TNUMBER)) {
                instr.push(new Instruction(INUMBER, this.current.value));
            } else if (this.accept(TSTRING)) {
                instr.push(new Instruction(INUMBER, this.current.value));
            } else if (this.accept(TPAREN, '(')) {
                this.parseExpression(instr);
                this.expect(TPAREN, ')');
            } else {
                throw new Error('unexpected ' + this.nextToken);
            }
        };

        ParserState.prototype.parseExpression = function (instr) {
            this.parseConditionalExpression(instr);
        };

        ParserState.prototype.parseConditionalExpression = function (instr) {
            this.parseOrExpression(instr);
            while (this.accept(TOP, '?')) {
                var trueBranch = [];
                var falseBranch = [];
                this.parseConditionalExpression(trueBranch);
                this.expect(TOP, ':');
                this.parseConditionalExpression(falseBranch);
                instr.push(new Instruction(IEXPR, trueBranch));
                instr.push(new Instruction(IEXPR, falseBranch));
                instr.push(ternaryInstruction('?'));
            }
        };

        ParserState.prototype.parseOrExpression = function (instr) {
            this.parseAndExpression(instr);
            while (this.accept(TOP, 'or')) {
                this.parseAndExpression(instr);
                instr.push(binaryInstruction('or'));
            }
        };

        ParserState.prototype.parseAndExpression = function (instr) {
            this.parseComparison(instr);
            while (this.accept(TOP, 'and')) {
                this.parseComparison(instr);
                instr.push(binaryInstruction('and'));
            }
        };

        ParserState.prototype.parseComparison = function (instr) {
            this.parseAddSub(instr);
            while (this.accept(TOP, ['==', '!=', '<', '<=', '>=', '>'])) {
                var op = this.current;
                this.parseAddSub(instr);
                instr.push(binaryInstruction(op.value));
            }
        };

        ParserState.prototype.parseAddSub = function (instr) {
            this.parseTerm(instr);
            while (this.accept(TOP, ['+', '-', '||'])) {
                var op = this.current;
                this.parseTerm(instr);
                instr.push(binaryInstruction(op.value));
            }
        };

        ParserState.prototype.parseTerm = function (instr) {
            this.parseFactor(instr);
            while (this.accept(TOP, ['*', '/', '%'])) {
                var op = this.current;
                this.parseFactor(instr);
                instr.push(binaryInstruction(op.value));
            }
        };

        ParserState.prototype.parseFactor = function (instr) {
            var unaryOps = this.tokens.unaryOps;
            function isPrefixOperator(token) {
                return token.value in unaryOps;
            }

            this.save();
            if (this.accept(TOP, isPrefixOperator)) {
                if ((this.current.value !== '-' && this.current.value !== '+' && this.nextToken.type === TPAREN && this.nextToken.value === '(')) {
                    this.restore();
                    this.parseExponential(instr);
                } else {
                    var op = this.current;
                    this.parseFactor(instr);
                    instr.push(unaryInstruction(op.value));
                }
            } else {
                this.parseExponential(instr);
            }
        };

        ParserState.prototype.parseExponential = function (instr) {
            this.parsePostfixExpression(instr);
            while (this.accept(TOP, '^')) {
                this.parseFactor(instr);
                instr.push(binaryInstruction('^'));
            }
        };

        ParserState.prototype.parsePostfixExpression = function (instr) {
            this.parseFunctionCall(instr);
            while (this.accept(TOP, '!')) {
                instr.push(unaryInstruction('!'));
            }
        };

        ParserState.prototype.parseFunctionCall = function (instr) {
            var unaryOps = this.tokens.unaryOps;
            function isPrefixOperator(token) {
                return token.value in unaryOps;
            }

            if (this.accept(TOP, isPrefixOperator)) {
                var op = this.current;
                this.parseAtom(instr);
                instr.push(unaryInstruction(op.value));
            } else {
                this.parseMemberExpression(instr);
                while (this.accept(TPAREN, '(')) {
                    if (this.accept(TPAREN, ')')) {
                        instr.push(new Instruction(IFUNCALL, 0));
                    } else {
                        var argCount = this.parseArgumentList(instr);
                        instr.push(new Instruction(IFUNCALL, argCount));
                    }
                }
            }
        };

        ParserState.prototype.parseArgumentList = function (instr) {
            var argCount = 0;

            while (!this.accept(TPAREN, ')')) {
                this.parseExpression(instr);
                ++argCount;
                while (this.accept(TCOMMA)) {
                    this.parseExpression(instr);
                    ++argCount;
                }
            }

            return argCount;
        };

        ParserState.prototype.parseMemberExpression = function (instr) {
            this.parseAtom(instr);
            while (this.accept(TOP, '.')) {
                this.expect(TNAME);
                instr.push(new Instruction(IMEMBER, this.current.value));
            }
        };

        function Parser() {
            this.unaryOps = {
                sin: Math.sin,
                cos: Math.cos,
                tan: Math.tan,
                asin: Math.asin,
                acos: Math.acos,
                atan: Math.atan,
                sinh: Math.sinh || sinh,
                cosh: Math.cosh || cosh,
                tanh: Math.tanh || tanh,
                asinh: Math.asinh || asinh,
                acosh: Math.acosh || acosh,
                atanh: Math.atanh || atanh,
                sqrt: Math.sqrt,
                log: Math.log,
                ln: Math.log,
                lg: Math.log10 || log10,
                log10: Math.log10 || log10,
                abs: Math.abs,
                ceil: Math.ceil,
                floor: Math.floor,
                round: Math.round,
                trunc: Math.trunc || trunc,
                '-': neg,
                '+': Number,
                exp: Math.exp,
                not: not,
                length: stringLength,
                '!': factorial
            };

            this.binaryOps = {
                '+': add,
                '-': sub,
                '*': mul,
                '/': div,
                '%': mod,
                '^': Math.pow,
                '||': concat,
                '==': equal,
                '!=': notEqual,
                '>': greaterThan,
                '<': lessThan,
                '>=': greaterThanEqual,
                '<=': lessThanEqual,
                and: andOperator,
                or: orOperator
            };

            this.ternaryOps = {
                '?': condition
            };

            this.functions = {
                money: money_format,
                float: float_format,
                random: random,
                fac: factorial,
                min: Math.min,
                max: Math.max,
                hypot: Math.hypot || hypot,
                pyt: Math.hypot || hypot, // backward compat
                pow: Math.pow,
                atan2: Math.atan2,
                'if': condition,
                gamma: gamma
            };

            this.consts = {
                E: Math.E,
                PI: Math.PI,
                'true': true,
                'false': false
            };
        }

        Parser.parse = function (expr) {
            return new Parser().parse(expr);
        };

        Parser.evaluate = function (expr, variables) {
            return Parser.parse(expr).evaluate(variables);
        };

        Parser.prototype = {
            parse: function (expr) {
                var instr = [];
                var parserState = new ParserState(this, new TokenStream(expr, this.unaryOps, this.binaryOps, this.ternaryOps, this.consts));
                parserState.parseExpression(instr);
                parserState.expect(TEOF, 'EOF');

                return new Expression(instr, this);
            },
            evaluate: function (expr, variables) {
                return this.parse(expr).evaluate(variables);
            }
        };

        var parser = {
            Parser: Parser,
            Expression: Expression
        };

        return parser;
    }
    function loadScript(path, callback) {
        var done = false;
        var scr = document.createElement('script');
        scr.onload = handleLoad;
        scr.onreadystatechange = handleReadyStateChange;
        scr.onerror = handleError;
        scr.src = path;
        document.body.appendChild(scr);
        function handleLoad() {
            if (!done) {
                done = true;
                callback(path, "ok");
            }
        }
        function handleReadyStateChange() {
            var state;

            if (!done) {
                state = scr.readyState;
                if (state === "complete") {
                    handleLoad();
                }
            }
        }
        function handleError() {
            if (!done) {
                done = true;
                callback(path, "error");
            }
        }
    }
    function float_format(value) {
        return numeral(value).format(azh.float_format);
    }
    function money_format(value) {
        return numeral(value).format(azh.money_format);
    }
    numeral.register('locale', 'custom', {
        delimiters: {
            thousands: azh.thousands_delimiter,
            decimal: azh.decimal_delimiter
        },
        abbreviations: {
            thousand: 'k',
            million: 'm',
            billion: 'b',
            trillion: 't'
        },
        ordinal: function (number) {
            var b = number % 10;
            return (~~(number % 100 / 10) === 1) ? 'th' :
                    (b === 1) ? 'st' :
                    (b === 2) ? 'nd' :
                    (b === 3) ? 'rd' : 'th';
        },
        currency: {
            symbol: azh.currency_symbol
        }
    });
    numeral.locale('custom');
    window.azh = $.extend({}, window.azh);
    azh.parse_query_string = function (a) {
        if (a == "")
            return {};
        var b = {};
        for (var i = 0; i < a.length; ++i)
        {
            var p = a[i].split('=');
            if (p.length != 2)
                continue;
            b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));
        }
        return b;
    };
    $.QueryString = azh.parse_query_string(window.location.search.substr(1).split('&'));
    var customize = ('azh' in $.QueryString && $.QueryString['azh'] == 'customize');
    $window.on('az-frontend-init', function (event, data) {
        function calculation($wrapper) {
            var calculated = false;
            $wrapper.find('[data-calculation]:not([data-calculation=""]):not(.az-calculated)').each(function () {
                function update() {
                    function calculate(text) {
                        text = text.replace(/{([^}]+)}/g, function (match, name, offset, s) {
                            var value = 0;
                            var pair = name.split('=');
                            if (pair.length === 1) {
                                var $field = $form.find('[name="' + name + '"]');
                                if ($field.length) {
                                    value = $field.val();
                                    if ($field.attr('type') === 'file') {
                                        value = value ? 1 : 0;
                                    }
                                    if ($field.attr('type') === 'checkbox' || $field.attr('type') === 'radio') {
                                        value = $field.prop('checked') ? 1 : 0;
                                    }
                                }
                            } else {
                                var $field = $form.find('[name="' + pair[0] + '"][value="' + pair[1] + '"]:checked');
                                if ($field.length) {
                                    value = 1;
                                } else {
                                    $field = $form.find('[name="' + pair[0] + '"]');
                                    if ($field.length && ($field.val() == pair[1])) {
                                        value = 1;
                                    }
                                }
                            }
                            return value;
                        });
                        $calculation.addClass('az-calculated');
                        calculated = true;
                        var result = '';
                        try {
                            if(text) {
                                result = MathParser().Parser.parse(text).evaluate({});
                            }
                        } catch(e) {
                            calculated = false;
                            $calculation.removeClass('az-calculated');
                            console.log('Formula error: ' + text);
                        };
                        return result;
                    }
                    if ($calculation.find('.az-calculation').length) {
                        $calculation.find('.az-calculation').text(calculate(calculation));
                    } else if ($calculation.find('.az-text').length) {
                        $calculation.find('.az-text').text(calculate(calculation));
                    } else {
                        $calculation.contents().filter(function () {
                            return this.nodeType === 3;
                        }).each(function () {
                            if ($.trim(this.textContent)) {
                                this.textContent = calculate(calculation);
                            }
                        });
                        $calculation.find('*').contents().filter(function () {
                            return this.nodeType === 3;
                        }).each(function () {
                            if ($.trim(this.textContent)) {
                                this.textContent = calculate(calculation);
                            }
                        });
                        if ($calculation.is('[name]')) {
                            $calculation.val(calculate(calculation));
                        }
                    }
                    $calculation.trigger('update');
                }
                var $calculation = $(this);
                var calculation = $(this).attr('data-calculation');
                var $form = $calculation.closest('form, [data-section]');
                if ($.trim(calculation)) {
                    $form.off('change.az-calculation').on('change.az-calculation', update);
                    update();
                }
            });
            return calculated;
        }
        var $wrapper = data.wrapper;
        $wrapper.find('[data-trigger-name][data-trigger-value]').each(function () {
            var $trigger = $(this);
            $trigger.find('a').css('pointer-events', 'none');
            $trigger.on('click', function () {
                var $this = $(this);
                var name = $(this).data('trigger-name');
                var value = $(this).data('trigger-value');
                var $input = $wrapper.find('[name="' + name + '"][value="' + value + '"]');
                if ($input.length) {
                    if ($input.attr('type') == 'checkbox') {
                        var checked = $input.prop('checked');
                        $input.prop('checked', !checked).trigger("change");
                        if (checked) {
                            $this.removeClass('az-triggered');
                        } else {
                            $this.addClass('az-triggered');
                        }
                    } else {
                        $wrapper.find('[data-trigger-name="' + name + '"]').removeClass('az-triggered');
                        $input.prop('checked', true).trigger("change");
                        $this.addClass('az-triggered');
                    }
                    return false;
                } else {
                    var $select = $wrapper.find('[name="' + name + '"]');
                    if ($select.length) {
                        var $option = $select.find('[value="' + value + '"]');
                        if ($option.length) {
                            if ($select.is('[multiple]')) {
                                var selected = $option.prop('selected');
                                $option.prop('selected', !checked).trigger("change");
                                if (selected) {
                                    $this.removeClass('az-triggered');
                                } else {
                                    $this.addClass('az-triggered');
                                }
                            } else {
                                $wrapper.find('[data-trigger-name="' + name + '"]').removeClass('az-triggered');
                                $option.prop('selected', true).trigger("change");
                                $this.addClass('az-triggered');
                            }
                            return false;
                        }
                    }
                }
            });
        });
        $wrapper.find('.az-steps').each(function () {
            function validate_form_part($form_part) {
                if (customize) {
                    return true;
                }
                var valid = true;
                $form_part.find('input,textarea,select').each(function () {
                    if ('reportValidity' in this) {
                        valid = this.reportValidity();
                    } else {
                        var $this = $(this);
                        $this.off('change.az-report-validity').on('change.az-report-validity', function () {
                            $(this).removeClass('az-not-valid');
                        });
                        $this.removeClass('az-not-valid');
                        if (!this.checkValidity()) {
                            valid = false;
                            $this.addClass('az-not-valid');
                        }
                    }
                });
                return valid;
            }
            var $steps = $(this);
            if (!$steps.data('az-steps')) {
                var $form = $steps.closest('form');
                var $submit = $form.find('[type="submit"]');
                $steps.find('> div:first-child > span > a[href^="#"]').on('click', function (event) {
                    var $this = $(this);
                    var step = $this.attr("href");
                    var $step = $(step);
                    var $buttons = $steps.find('> div:first-child > span');
                    var $active = $buttons.filter('.az-active');
                    var active_step = $active.find('a[href^="#"]').attr("href");
                    var $active_step = $(active_step);
                    if ($active.length == 0 || $active_step.nextAll().filter($step).length == 0 || validate_form_part($active_step)) {
                        $this.parent().addClass("az-active");
                        $this.parent().siblings().removeClass("az-active");
                        $steps.find('> div:last-child > div').not(step).css("display", "none");
                        $step.fadeIn();
                        if (!customize) {
                            if ($steps.find('> div:first-child > span').length > 1) {
                                if ($this.parent().is(':last-child')) {
                                    if ($submit.is('input')) {
                                        $submit.val(submit);
                                    }
                                    if ($submit.is('button')) {
                                        $submit.text(submit);
                                    }
                                }
                            }
                        }
                    }

                    event.preventDefault();
                });
                if (!customize) {
                    if ($steps.find('> div:first-child > span').length > 1) {
                        var submit = '';
                        if ($submit.is('input')) {
                            submit = $submit.val();
                            $submit.val(azh.i18n.next);
                        }
                        if ($submit.is('button')) {
                            submit = $submit.text();
                            $submit.text(azh.i18n.next);
                        }
                        $form.on('azh-before-submit', function (event, data) {
                            var $active = $steps.find('> div:first-child > span.az-active');
                            if ($active.is(':last-child') === false) {
                                $active.next().find('a[href^="#"]').click();
                                data.cancel = true;
//                                $('html, body').animate({
//                                    scrollTop: $form.offset().top - 100
//                                }, 500);
                            }
                        });
                        $form.on('azh-after-submit', function () {
                            if ($submit.is('input')) {
                                submit = $submit.val();
                                $submit.val(azh.i18n.next);
                            }
                            if ($submit.is('button')) {
                                submit = $submit.text();
                                $submit.text(azh.i18n.next);
                            }
                            $steps.find('> div:first-child > span:first-child > a[href^="#"]').click();
                        });
                    }
                }
                $steps.find('> div:first-child > span:first-child > a[href^="#"]').click();
                $steps.data('az-steps', true);
            }
        });
        if (!customize) {
            $wrapper.find('form').each(function () {
                function geolocation_init() {
                    if (navigator && navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function (position) {
                            $form.find('.az-geolocation input[name="latitude"]').val(parseFloat(position.coords.latitude)).trigger('change');
                            $form.find('.az-geolocation input[name="longitude"]').val(parseFloat(position.coords.longitude)).trigger('change');
                            if (google && google.maps && google.maps.Geocoder) {
                                var geocoder = new google.maps.Geocoder;
                                var latlng = {lat: parseFloat(position.coords.latitude), lng: parseFloat(position.coords.longitude)};
                                geocoder.geocode({'location': latlng}, function (results, status) {
                                    if (status === google.maps.GeocoderStatus.OK) {
                                        if (results[0]) {
                                            $form.find('.az-geolocation input[name="address"]').val(results[0].formatted_address).trigger('change');
                                        }
                                    }
                                });
                            }
                        });
                    }
                }
                var $form = $(this);
                if ('google' in window && 'maps' in google) {
                    geolocation_init();
                } else {
                    if ($wrapper.find('[data-gmap-api-key]').length) {
                        loadScript('//maps.googleapis.com/maps/api/js?key=' + $wrapper.find('[data-gmap-api-key]').data('gmap-api-key'), function (path, status) {
                            geolocation_init();
                        });
                    }
                }
            });
        }
        $wrapper.find('[data-conditional-logic]:not([data-conditional-logic=""])').each(function () {
            function update() {
                var all = true;
                var any = false;

                var fields = $form.serializeArray();
                var params = {};
                $.each(fields, function (i, field) {
                    if (field.name.indexOf('[]') > 0 && field.name in params) {
                        if (field.value != '') {
                            params[field.name] += ',' + field.value;
                        }
                    } else {
                        params[field.name] = field.value;
                    }
                });

                for (var i = 0; i < logic.conditions.length; i++) {
                    var condition = logic.conditions[i];
                    var value = params[condition.field] ? params[condition.field] : '';
                    switch (condition.condition) {
                        case 'is':
                            if (value == condition.value) {
                                any = true;
                            } else {
                                all = false;
                            }
                            break;
                        case 'is not':
                            if (value != condition.value) {
                                any = true;
                            } else {
                                all = false;
                            }
                            break;
                        case 'greater than':
                            if (parseFloat(value) > parseFloat(condition.value)) {
                                any = true;
                            } else {
                                all = false;
                            }
                            break;
                        case 'less than':
                            if (parseFloat(value) < parseFloat(condition.value)) {
                                any = true;
                            } else {
                                all = false;
                            }
                            break;
                        case 'contains':
                            if (value.indexOf(condition.value) >= 0) {
                                any = true;
                            } else {
                                all = false;
                            }
                            break;
                    }
                }
                switch (logic.mode) {
                    case 'show-if-all':
                        if (all) {
                            $logic.show()
                        } else {
                            $logic.hide()
                        }
                        break;
                    case 'show-if-any':
                        if (any) {
                            $logic.show()
                        } else {
                            $logic.hide()
                        }
                        break;
                    case 'hide-if-all':
                        if (all) {
                            $logic.hide()
                        } else {
                            $logic.show()
                        }
                        break;
                    case 'hide-if-any':
                        if (any) {
                            $logic.hide()
                        } else {
                            $logic.show()
                        }
                        break;
                }
            }
            var $logic = $(this);
            var logic = $(this).attr('data-conditional-logic').replace(/\'/g, '"');
            logic = JSON.parse(logic);
            var $form = $logic.closest('form');
            if (!customize) {
                $form.find('[name]').each(function () {
                    var $field = $(this);
                    for (var i = 0; i < logic.conditions.length; i++) {
                        var condition = logic.conditions[i];
                        if ($field.attr('name') === condition.field) {
                            $field.on('change', update);
                        }
                    }
                });
                update();
            }
        });
        var i = 10;
        while (calculation($wrapper) && i) {
            i--;
        }
        $wrapper.find('.az-multiplication').each(function () {
            function update() {
                function calculate() {
                    var total = 1;
                    $multiplication.find('[data-factor]').each(function () {
                        var $this = $(this);
                        if (!$this.parentsUntil($multiplication).filter('[data-factor].az-active').length) {
                            if ($this.is(':checked, :selected, .az-active')) {
                                var value = 1;
                                if ($this.is('[type="number"]')) {
                                    value = parseFloat($this.val());
                                }
                                total = total * parseFloat($this.attr('data-factor')) * value;
                            }
                        }
                    });
                    return total;
                }
                $multiplication.attr('data-factor', calculate()).trigger('update');
            }
            var $multiplication = $(this).on('change', update);
            update();
        });
        $wrapper.find('.az-sum').each(function () {
            function update() {
                function calculate() {
                    var total = 0;
                    $sum.find('[data-factor]').each(function () {
                        var $this = $(this);
                        if (!$this.parentsUntil($sum).filter('[data-factor].az-active').length) {
                            if ($this.is(':checked, :selected, .az-active')) {
                                var value = 1;
                                if ($this.is('[type="number"]')) {
                                    value = parseFloat($this.val());
                                }
                                total = total + parseFloat($this.attr('data-factor')) * value;
                            }
                        }
                    });
                    return total;
                }
                $sum.attr('data-factor', calculate()).trigger('update');
            }
            var $sum = $(this).on('change', update);
            update();
        });
        $wrapper.find('.az-total').each(function () {
            function update() {
                function calculate() {
                    var total = 0;
                    $form.find('[data-factor]').each(function () {
                        var $this = $(this);
                        if (!$this.parents('[data-factor].az-active').length) {
                            if ($this.is(':checked, :selected, .az-active')) {
                                var value = 1;
                                if ($this.is('[type="number"]')) {
                                    value = parseFloat($this.val());
                                }
                                total = total + parseFloat($this.attr('data-factor')) * value;
                            }
                        }
                    });
                    return total;
                }
                $total.find('.az-calculation').text(money_format(calculate()));
                $total.find('.az-result').val(calculate());
                $total.trigger('update');
            }
            var $total = $(this);
            var $form = $total.closest('form, [data-section]').on('change', update);
            update();
        });
        $wrapper.find('p.az-increment-decrement').each(function () {
            var $field = $(this);
            var $input = $field.find('input');
            $field.find('.az-increment').off('click').on('click', function () {
                $input.get(0).stepUp();
                $input.trigger('change');
                return false;
            });
            $field.find('.az-decrement').off('click').on('click', function () {
                $input.get(0).stepDown();
                $input.trigger('change');
                return false;
            });
        });
        $wrapper.find('form').each(function () {
            var $form = $(this);
            $form.on('azh-before-submit', function (event, data) {
                var $paypal = $form.find('.az-paypal');
                if ($paypal.length) {
                    var amount = $paypal.find('.az-calculation').text();
                    amount = parseFloat(amount.replace(/[^\d\,\.]/g, ''));
                    data.fields['az-paypal-item-name'] = $paypal.find('.az-item-name').val();
                    data.fields['az-paypal-amount'] = $paypal.find('.az-calculation').text();

                }
            });
        });
    });
})(window.jQuery);