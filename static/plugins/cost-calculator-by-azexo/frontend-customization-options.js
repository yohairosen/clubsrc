(function($) {
    "use strict";
    function transition_utility(selector, group, subgroup, refresh, multiplying_selector) {
        azh.controls_options = azh.controls_options.concat([
            {
                "type": "integer-style",
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "menu": "utility",
                "group": group,
                "subgroup": subgroup,
                "min": "0",
                "max": "1",
                "step": "0.05",
                "units": "s",
                "control_class": "azh-transition-duration",
                "control_type": "transition-duration",
                "control_text": "Transition duration",
                "property": "transition-duration"
            },
            {
                "refresh": refresh,
                "type": "dropdown-style",
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "menu": "utility",
                "group": group,
                "subgroup": subgroup,
                "options": {
                    "linear": "linear",
                    "ease": "ease",
                    "ease-in": "ease-in",
                    "ease-out": "ease-out",
                    "ease-in-out": "ease-in-out"
                },
                "property": "transition-timing-function",
                "control_class": "azh-transition-timing-function",
                "control_type": "transition-timing-function",
                "control_text": "Transition timing function"
            }
        ]);
    }
    function font_utility(selector, group, subgroup, attribute, refresh, multiplying_selector) {
        if (attribute === 'data-hover') {
            transition_utility(selector, group, subgroup, refresh, multiplying_selector);
        }
        azh.controls_options = azh.controls_options.concat([
            {
                "refresh": refresh,
                "type": "font-family",
                "menu": "utility",
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "property": "font-family",
                "control_class": "azh-font-family",
                "control_type": "font-family",
                "control_text": "Font family"
            },
            {
                "refresh": refresh,
                "type": "integer-style",
                "menu": "utility",
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "property": "font-size",
                "responsive": true,
                "slider": true,
                "units": {
                    "px": {
                        "min": "1",
                        "max": "200",
                        "step": "1"
                    },
                    "em": {
                        "min": "0.1",
                        "max": "10",
                        "step": "0.1"
                    },
                    "rem": {
                        "min": "0.1",
                        "max": "10",
                        "step": "0.1"
                    }
                },
                "control_class": "azh-integer",
                "control_type": "font-size",
                "control_text": "Font size"
            },
            {
                "refresh": refresh,
                "type": "dropdown-style",
                "menu": "utility",
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "property": "font-weight",
                "options": {
                    "100": "100",
                    "200": "200",
                    "300": "300",
                    "400": "400",
                    "500": "500",
                    "600": "600",
                    "700": "700",
                    "800": "800",
                    "900": "900"
                },
                "control_class": "azh-dropdown",
                "control_type": "font-weight",
                "control_text": "Font weight"
            },
            {
                "refresh": refresh,
                "type": "dropdown-style",
                "menu": "utility",
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "property": "font-style",
                "options": {
                    "": "Default",
                    "normal": "Normal",
                    "italic": "Italic",
                    "oblique": "Oblique"
                },
                "control_class": "azh-dropdown",
                "control_type": "font-style",
                "control_text": "Font style"
            },
            {
                "refresh": refresh,
                "type": "dropdown-style",
                "menu": "utility",
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "property": "text-transform",
                "options": {
                    "": "Default",
                    "uppercase": "Uppercase",
                    "lowercase": "Lowercase",
                    "capitalize": "Capitalize",
                    "none": "Normal"
                },
                "control_class": "azh-dropdown",
                "control_type": "text-transform",
                "control_text": "Transform"
            },
            {
                "refresh": refresh,
                "type": "color-style",
                "menu": "utility",
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "property": "color",
                "control_class": "azh-color",
                "control_type": "color",
                "control_text": "Color"
            }
        ]);
    }
    function text_utility(selector, group, subgroup, attribute, refresh, multiplying_selector) {
        if (attribute === 'data-hover') {
            transition_utility(selector, group, subgroup, refresh, multiplying_selector);
        }
        azh.controls_options = azh.controls_options.concat([
            {
                "refresh": refresh,
                "type": "integer-style",
                "menu": "utility",
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "responsive": true,
                "property": "line-height",
                "slider": true,
                "units": {
                    "px": {
                        "min": "1",
                        "max": "100",
                        "step": "1"
                    },
                    "%": {
                        "min": "1",
                        "max": "300",
                        "step": "1"
                    },
                    "em": {
                        "min": "0.1",
                        "max": "10",
                        "step": "0.1"
                    }
                },
                "control_class": "azh-integer",
                "control_type": "line-height",
                "control_text": "Line height"
            },
            {
                "refresh": refresh,
                "type": "radio-style",
                "menu": "utility",
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "responsive": true,
                "property": "text-align",
                "options": {
                    "left": "Left",
                    "center": "Center",
                    "right": "Right",
                    "justify": "Justify"
                },
                "control_class": "azh-text-align",
                "control_type": "text-align",
                "control_text": "Text align"
            },
            {
                "refresh": refresh,
                "type": "integer-style",
                "menu": "utility",
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "responsive": true,
                "property": "word-spacing",
                "min": "-20",
                "max": "50",
                "step": "1",
                "units": "px",
                "control_class": "azh-integer",
                "control_type": "word-spacing",
                "control_text": "Word-spacing"
            },
            {
                "refresh": refresh,
                "type": "integer-style",
                "menu": "utility",
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "responsive": true,
                "property": "letter-spacing",
                "min": "-5",
                "max": "10",
                "step": "0.1",
                "units": "px",
                "control_class": "azh-integer",
                "control_type": "letter-spacing",
                "control_text": "Letter-spacing"
            }
        ]);
    }
    function background_utility(selector, group, subgroup, attribute, refresh, multiplying_selector) {
        if (attribute === 'data-hover') {
            transition_utility(selector, group, subgroup, refresh, multiplying_selector);
        }
        azh.controls_options = azh.controls_options.concat([
            {
                "refresh": function($control, $element) {
                    $control.parent().find('.azh-control').trigger('azh-init');
                    if ($control.attr('data-value') === 'classic') {
                        $control.parent().find('.azh-background-image img').trigger('contextmenu');
                    }
                    if ($control.attr('data-value') === 'gradient') {
                        $control.parent().find('.azh-background-gradient-type select').trigger('change');
                    }
                },
                "type": "radio-style",
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "menu": "utility",
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "options": {
                    "classic": "Classic",
                    "gradient": "Gradient"
                },
                "property": "background-type",
                "control_class": "azh-background-type",
                "control_type": "background-type",
                "control_text": "Background type"
            },
            {
                "refresh": refresh,
                "type": "color-style",
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "menu": "utility",
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "property": "background-color",
                "control_class": "azh-background-color",
                "control_type": "background-color",
                "control_text": "Background color"
            },
            {
                "refresh": refresh,
                "type": "background-image",
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "menu": "utility",
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "control_class": "azh-background-image",
                "control_type": "background-image",
                "control_text": "Background image"
            },
            {
                "refresh": refresh,
                "type": "dropdown-style",
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "menu": "utility",
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "responsive": true,
                "options": {
                    "": "Default",
                    "top left": "Top Left",
                    "top center": "Top Center",
                    "top right": "Top Right",
                    "center left": "Center Left",
                    "center center": "Center Center",
                    "center right": "Center Right",
                    "bottom left": "Bottom Left",
                    "bottom center": "Bottom Center",
                    "bottom right": "Bottom Right"
                },
                "property": "background-position",
                "control_class": "azh-background-position",
                "control_type": "background-position",
                "control_text": "Position"
            },
            {
                "refresh": refresh,
                "type": "dropdown-style",
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "menu": "utility",
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "options": {
                    "": "Default",
                    "scroll": "Scroll",
                    "fixed": "Fixed"
                },
                "property": "background-attachment",
                "control_class": "azh-background-attachment",
                "control_type": "background-attachment",
                "control_text": "Attachment"
            },
            {
                "refresh": refresh,
                "type": "dropdown-style",
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "menu": "utility",
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "options": {
                    "": "Default",
                    "no-repeat": "No repeat",
                    "repeat": "Repeat",
                    "repeat-x": "Repeat-x",
                    "repeat-y": "Repeat-y"
                },
                "property": "background-repeat",
                "control_class": "azh-background-repeat",
                "control_type": "background-repeat",
                "control_text": "Repeat"
            },
            {
                "refresh": refresh,
                "type": "dropdown-style",
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "menu": "utility",
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "options": {
                    "": "Default",
                    "auto": "Auto",
                    "cover": "Cover",
                    "contain": "Contain"
                },
                "property": "background-size",
                "control_class": "azh-background-size",
                "control_type": "background-size",
                "control_text": "Size"
            },
            {
                "refresh": function($control, $element) {
                    $control.parent().find('.azh-control').trigger('azh-init');
                },
                "type": "dropdown-style",
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "menu": "utility",
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "options": {
                    "linear-gradient": "Linear",
                    "radial-gradient": "Radial"
                },
                "property": "background-image",
                "pattern": /()([-\w]+)(\(\d+deg, rgba\(\d+,\d+,\d+,\d.?\d*\) \d+%, rgba\(\d+,\d+,\d+,\d.?\d*\) \d+%\))/,
                "default": "linear-gradient(180deg, rgba(255,0,0,1) 50%, rgba(0,255,0,1) 50%)",
                "control_class": "azh-background-gradient-type",
                "control_type": "background-gradient-type",
                "control_text": "Type"
            },
            {
                "refresh": refresh,
                "type": "dropdown-style",
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "menu": "utility",
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "options": {
                    "top left": "Top Left",
                    "top center": "Top Center",
                    "top right": "Top Right",
                    "center left": "Center Left",
                    "center center": "Center Center",
                    "center right": "Center Right",
                    "bottom left": "Bottom Left",
                    "bottom center": "Bottom Center",
                    "bottom right": "Bottom Right"
                },
                "property": "background-image",
                "pattern": /(radial-gradient\(at )([ \w]+)(, rgba\(\d+,\d+,\d+,\d.?\d*\) \d+%, rgba\(\d+,\d+,\d+,\d.?\d*\) \d+%\))/,
                "default": "radial-gradient(at center center, rgba(255,0,0,1) 50%, rgba(0,255,0,1) 50%)",
                "control_class": "azh-background-radial-gradient-position",
                "control_type": "background-radial-gradient-position",
                "control_text": "Position"
            },
            {
                "refresh": refresh,
                "type": "integer-style",
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "menu": "utility",
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "property": "background-image",
                "pattern": /(linear-gradient\()(\d+)(deg, rgba\(\d+,\d+,\d+,\d.?\d*\) \d+%, rgba\(\d+,\d+,\d+,\d.?\d*\) \d+%\))/,
                "default": "linear-gradient(180deg, rgba(255,0,0,1) 50%, rgba(0,255,0,1) 50%)",
                "min": 0,
                "max": 360,
                "step": 1,
                "control_class": "azh-background-linear-gradient-angle",
                "control_type": "background-linear-gradient-angle",
                "control_text": "Angle"
            },
            {
                "refresh": refresh,
                "type": "color-style",
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "menu": "utility",
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "property": "background-image",
                "pattern": /(linear-gradient\(\d+deg, )(rgba\(\d+,\d+,\d+,\d.?\d*\))( \d+%, rgba\(\d+,\d+,\d+,\d.?\d*\) \d+%\))/,
                "default": "linear-gradient(180deg, rgba(255,0,0,1) 50%, rgba(0,255,0,1) 50%)",
                "min": 0,
                "max": 100,
                "step": 1,
                "control_class": "azh-background-linear-gradient-color",
                "control_type": "background-linear-gradient-first-color",
                "control_text": "First color"
            },
            {
                "refresh": refresh,
                "type": "integer-style",
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "menu": "utility",
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "property": "background-image",
                "pattern": /(linear-gradient\(\d+deg, rgba\(\d+,\d+,\d+,\d.?\d*\) )(\d+)(%, rgba\(\d+,\d+,\d+,\d.?\d*\) \d+%\))/,
                "default": "linear-gradient(180deg, rgba(255,0,0,1) 50%, rgba(0,255,0,1) 50%)",
                "min": 0,
                "max": 100,
                "step": 1,
                "control_class": "azh-background-linear-gradient-location",
                "control_type": "background-linear-gradient-first-location",
                "control_text": "First location"
            },
            {
                "refresh": refresh,
                "type": "color-style",
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "menu": "utility",
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "property": "background-image",
                "pattern": /(linear-gradient\(\d+deg, rgba\(\d+,\d+,\d+,\d.?\d*\) \d+%, )(rgba\(\d+,\d+,\d+,\d.?\d*\))( \d+%\))/,
                "default": "linear-gradient(180deg, rgba(255,0,0,1) 50%, rgba(0,255,0,1) 50%)",
                "min": 0,
                "max": 100,
                "step": 1,
                "control_class": "azh-background-linear-gradient-color",
                "control_type": "background-linear-gradient-second-color",
                "control_text": "Second color"
            },
            {
                "refresh": refresh,
                "type": "integer-style",
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "menu": "utility",
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "property": "background-image",
                "pattern": /(linear-gradient\(\d+deg, rgba\(\d+,\d+,\d+,\d.?\d*\) \d+%, rgba\(\d+,\d+,\d+,\d.?\d*\) )(\d+)(%\))/,
                "default": "linear-gradient(180deg, rgba(255,0,0,1) 50%, rgba(0,255,0,1) 50%)",
                "min": 0,
                "max": 100,
                "step": 1,
                "control_class": "azh-background-linear-gradient-location",
                "control_type": "background-linear-gradient-second-location",
                "control_text": "Second location"
            },
            {
                "refresh": refresh,
                "type": "color-style",
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "menu": "utility",
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "property": "background-image",
                "pattern": /(radial-gradient\(at [ \w]+, )(rgba\(\d+,\d+,\d+,\d.?\d*\))( \d+%, rgba\(\d+,\d+,\d+,\d.?\d*\) \d+%\))/,
                "default": "radial-gradient(at center center, rgba(255,0,0,1) 50%, rgba(0,255,0,1) 50%)",
                "min": 0,
                "max": 100,
                "step": 1,
                "control_class": "azh-background-radial-gradient-color",
                "control_type": "background-radial-gradient-first-color",
                "control_text": "First color"
            },
            {
                "refresh": refresh,
                "type": "integer-style",
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "menu": "utility",
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "property": "background-image",
                "pattern": /(radial-gradient\(at [ \w]+, rgba\(\d+,\d+,\d+,\d.?\d*\) )(\d+)(%, rgba\(\d+,\d+,\d+,\d.?\d*\) \d+%\))/,
                "default": "radial-gradient(at center center, rgba(255,0,0,1) 50%, rgba(0,255,0,1) 50%)",
                "min": 0,
                "max": 100,
                "step": 1,
                "control_class": "azh-background-radial-gradient-location",
                "control_type": "background-radial-gradient-first-location",
                "control_text": "First location"
            },
            {
                "refresh": refresh,
                "type": "color-style",
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "menu": "utility",
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "property": "background-image",
                "pattern": /(radial-gradient\(at [ \w]+, rgba\(\d+,\d+,\d+,\d.?\d*\) \d+%, )(rgba\(\d+,\d+,\d+,\d.?\d*\))( \d+%\))/,
                "default": "radial-gradient(at center center, rgba(255,0,0,1) 50%, rgba(0,255,0,1) 50%)",
                "min": 0,
                "max": 100,
                "step": 1,
                "control_class": "azh-background-radial-gradient-color",
                "control_type": "background-radial-gradient-second-color",
                "control_text": "Second color"
            },
            {
                "refresh": refresh,
                "type": "integer-style",
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "menu": "utility",
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "property": "background-image",
                "pattern": /(radial-gradient\(at [ \w]+, rgba\(\d+,\d+,\d+,\d.?\d*\) \d+%, rgba\(\d+,\d+,\d+,\d.?\d*\) )(\d+)(%\))/,
                "default": "radial-gradient(at center center, rgba(255,0,0,1) 50%, rgba(0,255,0,1) 50%)",
                "min": 0,
                "max": 100,
                "step": 1,
                "control_class": "azh-background-radial-gradient-location",
                "control_type": "background-radial-gradient-second-location",
                "control_text": "Second location"
            }
        ]);
    }
    function border_utility(selector, group, subgroup, attribute, refresh, multiplying_selector) {
        if (attribute === 'data-hover') {
            transition_utility(selector, group, subgroup, refresh, multiplying_selector);
        }
        azh.controls_options = azh.controls_options.concat([
            {
                "refresh": refresh,
                "type": "dropdown-style",
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "menu": "utility",
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "options": {
                    "none": "None",
                    "solid": "Solid",
                    "double": "Double",
                    "dotted": "Dotted",
                    "dashed": "Dashed"
                },
                "property": "border-style",
                "control_class": "azh-border-style",
                "control_type": "border-style",
                "control_text": "Border type"
            },
            {
                "refresh": refresh,
                "type": "color-style",
                "menu": "utility",
                "group": group,
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "subgroup": subgroup,
                "attribute": attribute,
                "property": "border-color",
                "control_class": "azh-border-color",
                "control_type": "border-color",
                "control_text": "Border color"
            },
            {
                "refresh": refresh,
                "type": "integer-list-style",
                "menu": "utility",
                "group": group,
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "subgroup": subgroup,
                "attribute": attribute,
                "responsive": true,
                "properties": {
                    "border-top-width": "Top",
                    "border-right-width": "Right",
                    "border-bottom-width": "Bottom",
                    "border-left-width": "left"
                },
                "min": "0",
                "max": "100",
                "step": "1",
                "units": "px",
                "control_class": "azh-border-width",
                "control_type": "border-width",
                "control_text": "Border width"
            },
            {
                "refresh": refresh,
                "type": "integer-list-style",
                "menu": "utility",
                "group": group,
                "selector": selector,
                "multiplying_selector": multiplying_selector,
                "subgroup": subgroup,
                "attribute": attribute,
                "responsive": true,
                "properties": {
                    "border-top-left-radius": "Top Left",
                    "border-top-right-radius": "Top Right",
                    "border-bottom-left-radius": "Bottom Left",
                    "border-bottom-right-radius": "Bottom Right"
                },
                "slider": true,
                "units": {
                    "px": {
                        "min": "0",
                        "max": "100",
                        "step": "1"
                    },
                    "%": {
                        "min": "0",
                        "max": "50",
                        "step": "1"
                    }
                },
                "control_class": "azh-border-radius",
                "control_type": "border-radius",
                "control_text": "Border radius"
            }
        ]);
    }
    function box_shadow_utility(selector, group, subgroup, attribute, refresh) {
        if (attribute === 'data-hover') {
            transition_utility(selector, group, subgroup, refresh);
        }
        azh.controls_options = azh.controls_options.concat([
            {
                "refresh": refresh,
                "type": "exists-style",
                "selector": selector,
                "menu": "utility",
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "property": "box-shadow",
                "value": "0px 0px 0px 0px rgba(0,0,0,1)",
                "control_class": "azh-toggle azh-box-shadow",
                "control_type": "box-shadow",
                "control_text": "Box shadow"
            },
            {
                "refresh": refresh,
                "type": "color-style",
                "menu": "utility",
                "group": group,
                "selector": selector,
                "subgroup": subgroup,
                "attribute": attribute,
                "property": "box-shadow",
                "pattern": /(-?\d+px -?\d+px \d+px -?\d+px )(rgba\(\d+,\d+,\d+,\d.?\d*\))()/,
                "default": "0px 0px 0px 0px rgba(0,0,0,1)",
                "control_class": "azh-box-shadow-color",
                "control_type": "box-shadow-color",
                "control_text": "Color"
            },
            {
                "refresh": refresh,
                "type": "integer-style",
                "selector": selector,
                "menu": "utility",
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "property": "box-shadow",
                "pattern": /(-?\d+px -?\d+px )(\d+)(px -?\d+px rgba\(\d+,\d+,\d+,\d.?\d*\))/,
                "default": "0px 0px 0px 0px rgba(0,0,0,1)",
                "min": 0,
                "max": 100,
                "step": 1,
                "control_class": "azh-box-shadow-blur",
                "control_type": "box-shadow-blur",
                "control_text": "Blur"
            },
            {
                "refresh": refresh,
                "type": "integer-style",
                "selector": selector,
                "menu": "utility",
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "property": "box-shadow",
                "pattern": /(-?\d+px -?\d+px \d+px )(-?\d+)(px rgba\(\d+,\d+,\d+,\d.?\d*\))/,
                "default": "0px 0px 0px 0px rgba(0,0,0,1)",
                "min": -100,
                "max": 100,
                "step": 1,
                "control_class": "azh-box-shadow-spread",
                "control_type": "box-shadow-spread",
                "control_text": "Spread"
            },
            {
                "refresh": refresh,
                "type": "integer-style",
                "selector": selector,
                "menu": "utility",
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "property": "box-shadow",
                "pattern": /()(-?\d+)(px -?\d+px \d+px -?\d+px rgba\(\d+,\d+,\d+,\d.?\d*\))/,
                "default": "0px 0px 0px 0px rgba(0,0,0,1)",
                "min": -100,
                "max": 100,
                "step": 1,
                "control_class": "azh-box-shadow-horizontal",
                "control_type": "box-shadow-horizontal",
                "control_text": "Horizontal"
            },
            {
                "refresh": refresh,
                "type": "integer-style",
                "selector": selector,
                "menu": "utility",
                "group": group,
                "subgroup": subgroup,
                "attribute": attribute,
                "property": "box-shadow",
                "pattern": /(-?\d+px )(-?\d+)(px \d+px -?\d+px rgba\(\d+,\d+,\d+,\d.?\d*\))/,
                "default": "0px 0px 0px 0px rgba(0,0,0,1)",
                "min": -100,
                "max": 100,
                "step": 1,
                "control_class": "azh-box-shadow-vertical",
                "control_type": "box-shadow-vertical",
                "control_text": "Vertical"
            }
        ]);
    }
    function box_utility(selector, group, multiplying_selector) {
        azh.controls_options = azh.controls_options.concat([
            {
                "type": "integer-list-style",
                "menu": "utility",
                "group": group,
                "responsive": true,
                "properties": {
                    "margin-top": "Top",
                    "margin-right": "Right",
                    "margin-bottom": "Bottom",
                    "margin-left": "left"
                },
                "min": "-300",
                "max": "300",
                "step": "1",
                "units": "px",
                "control_class": "azh-integer-list",
                "control_type": "box-margin",
                "control_text": "Margin",
                "multiplying_selector": multiplying_selector,
                "selector": selector
            },
            {
                "type": "integer-list-style",
                "menu": "utility",
                "group": group,
                "responsive": true,
                "properties": {
                    "padding-top": "Top",
                    "padding-right": "Right",
                    "padding-bottom": "Bottom",
                    "padding-left": "left"
                },
                "min": "0",
                "max": "300",
                "step": "1",
                "units": "px",
                "control_class": "azh-integer-list",
                "control_type": "box-padding",
                "control_text": "Padding",
                "multiplying_selector": multiplying_selector,
                "selector": selector
            }
        ]);
    }
    function number_field_utility() {
        azh.controls_options = azh.controls_options.concat([
            {
                "type": "radio-classes",
                "menu": "utility",
                "selector": "form input.az-number-field",
                "property": "margin",
                "classes": {
                    "az-left": "Left",
                    "az-center": "Center",
                    "az-right": "Right",
                    "az-full-width": "Full width",
                },
                "control_class": "azh-horizontal-align",
                "control_type": "horizontal-align",
                "control_text": "Horizontal align"
            },
            {
                "type": "input-attribute",
                "menu": "utility",
                "group": "Number field settings",
                "control_text": "Field name",
                "control_class": "azh-name",
                "control_type": "name",
                "selector": "[name].az-number-field",
                "attribute": "name",
                "unique_wrapper": 'form, [data-section]',
                "unique": '[name="{name}"]',
                "unique_exception": '[name*="[]"]'
            },
            {
                "type": "exists-attribute",
                "menu": "utility",
                "group": "Number field settings",
                "control_text": "Required",
                "control_class": "azh-toggle",
                "control_type": "required",
                "selector": "form input.az-number-field",
                "attribute": "required"
            },
            {
                "type": "input-attribute",
                "menu": "utility",
                "group": "Number field settings",
                "control_text": "Default field value",
                "control_class": "azh-value",
                "control_type": "value",
                "selector": "input[value].az-number-field",
                "attribute": "value"
            },
            {
                "type": "input-attribute",
                "menu": "utility",
                "group": "Number field settings",
                "control_text": "Minimum",
                "control_class": "azh-minimum",
                "control_type": "minimum",
                "selector": "input[min].az-number-field",
                "attribute": "min"
            },
            {
                "type": "input-attribute",
                "menu": "utility",
                "group": "Number field settings",
                "control_text": "Maximum",
                "control_class": "azh-maximum",
                "control_type": "maximum",
                "selector": "input[max].az-number-field",
                "attribute": "max"
            },
            {
                "type": "input-attribute",
                "menu": "utility",
                "group": "Number field settings",
                "control_text": "Step",
                "control_class": "azh-step",
                "control_type": "step",
                "selector": "input[step].az-number-field",
                "attribute": "step"
            },
            {
                "type": "input-attribute",
                "menu": "utility",
                "group": "Number field settings",
                "control_text": "Field placeholder",
                "control_class": "azh-field-placeholder",
                "control_type": "field-placeholder",
                "selector": "[placeholder].az-number-field",
                "attribute": "placeholder"
            },
            {
                "type": "integer-attribute",
                "menu": "utility",
                "group": "Number field settings",
                "step": "0.01",
                "control_text": "Factor (price, ratio)",
                "control_class": "azh-factor",
                "control_type": "factor",
                "selector": "form input[type='number'].az-number-field",
                "attribute": "data-factor"
            }
        ]);
        font_utility('.az-number-field', 'Number field font styles');
        text_utility('.az-number-field', 'Number field text styles');
        background_utility('.az-number-field', 'Number field background');
        border_utility('.az-number-field', 'Number field border');
        box_shadow_utility('.az-number-field', 'Number field shadow');
        box_utility('.az-number-field', "Number field-box styles");
    }

    window.azh = $.extend({}, window.azh);
    if (!('controls_options' in azh)) {
        azh.controls_options = [];
    }
    azh.controls_options = azh.controls_options.concat([
        {
            "type": "integer-attribute",
            "menu": "utility",
            "group": "Form field settings",
            "step": "0.01",
            "control_text": "Factor (price, ratio)",
            "control_class": "azh-checkbox-factor",
            "control_type": "checkbox-factor",
            "selector": "form .az-checkboxes input[type='checkbox']",
            "attribute": "data-factor"
        },
        {
            "type": "integer-attribute",
            "menu": "utility",
            "group": "Form field settings",
            "step": "0.01",
            "control_text": "Factor (price, ratio)",
            "control_class": "azh-radio-factor",
            "control_type": "radio-factor",
            "selector": ".az-radio-buttons input[type='radio']",
            "attribute": "data-factor"
        },
        {
            "type": "integer-attribute",
            "menu": "utility",
            "group": "Form field settings",
            "step": "0.01",
            "control_text": "Factor (price, ratio)",
            "control_class": "azh-option-factor",
            "control_type": "option-factor",
            "selector": "select.az-select option",
            "attribute": "data-factor"
        },
        {
            "type": "input-attribute",
            "selector": ".az-geolocation[data-gmap-api-key]",
            "menu": "utility",
            "attribute": "data-gmap-api-key",
            "control_class": "azh-text",
            "control_type": "gmap-api-key",
            "control_text": "Google Map API key"
        },
        {
            "type": "exists-class",
            "menu": "utility",
            "control_text": "Submission confirmation",
            "control_class": "azh-toggle",
            "control_type": "azh-confirmation",
            "selector": "form [data-column-padding]",
            "class": "az-confirmation"
        },
        {
            "type": "dropdown-attribute",
            "menu": "utility",
            "options": "name",
            "attribute": "data-trigger-name",
            "control_class": "azh-dropdown",
            "control_type": "trigger-name",
            "description": "Enable checkbox or radio field with name/value pair",
            "control_text": "Trigger name"
        },
        {
            "type": "dropdown-attribute",
            "menu": "utility",
            "options": "value",
            "attribute": "data-trigger-value",
            "control_class": "azh-dropdown",
            "control_type": "trigger-value",
            "description": "Enable checkbox or radio field with name/value pair",
            "control_text": "Trigger value"
        },
        {
            "type": "color-style",
            "selector": '.az-color-fan label span.az-color',
            "menu": "utility",
            "group": "Form field settings",
            "property": "background-color",
            "control_class": "azh-background-color",
            "control_type": "background-color",
            "control_text": "Color"
        },
        {
            "type": "icon-class",
            "menu": "utility",
            "group": "Form field settings",
            "control_class": "azh-icon",
            "control_type": "icon",
            "control_text": "Icon",
            "selector": '.az-icons-field label > span.az-icon'
        },
        {
            "type": "image-attribute",
            "menu": "utility",
            "group": "Form field settings",
            "attribute": "src",
            "control_class": "azh-image",
            "control_type": "image",
            "control_text": "Image URL",
            "selector": '.az-images-field label img'
        },
    ]);

    text_utility('.az-paypal', 'Text styles');
    font_utility('.az-paypal', 'Font styles');
    text_utility('.az-total', 'Text styles');
    font_utility('.az-total', 'Font styles');
    number_field_utility();
    font_utility('span.az-increment-decrement', 'Inc/Dec font', 'Normal');
    font_utility('span.az-increment-decrement', 'Inc/Dec font', 'Hover', 'data-hover');
    border_utility('span.az-increment-decrement', 'Inc/Dec border', 'Normal', null, null, 'span');
    border_utility('span.az-increment-decrement', 'Inc/Dec border', 'Hover', 'data-hover', null, 'span');
    background_utility('span.az-increment-decrement', 'Inc/Dec background', 'Normal', null, null, 'span');
    background_utility('span.az-increment-decrement', 'Inc/Dec background', 'Hover', 'data-hover', null, 'span');
    box_utility('span.az-increment-decrement', "Inc/Dec-box styles", 'span');

    if (!('modal_options' in azh)) {
        azh.modal_options = [];
    }
    azh.modal_options = azh.modal_options.concat([
        {
            "menu": 'utility',
            "button_text": "Conditional logic",
            "button_class": "azh-conditional-logic",
            "button_type": "azh-conditional-logic",
            "title": "Conditional logic",
            "selector": 'form [data-element]',
            "type": "textarea",
            "attribute": 'data-conditional-logic',
            "callback": function($element, $modal) {
                function add_condition(i) {
                    var condition = logic.conditions[i];
                    var $row = $('<div class="azh-row"></div>').appendTo($table);
                    var $field = $('<div class="azh-cell azh-field"></div>').appendTo($row);
                    var $fields = $('<select></select>').appendTo($field).on('change', function() {
                        condition.field = $(this).val();
                        $textarea.val(JSON.stringify(logic).replace(/\"/g, "'"));
                    });
                    var fields = {};
                    $form.find('[name]:not([name="' + $element.find('[name]').attr('name') + '"])').each(function() {
                        fields[$(this).attr('name')] = $(this).attr('name');
                    });
                    for (var name in fields) {
                        $('<option value="' + name + '">' + name + '</select>').appendTo($fields);
                    }
                    $fields.val(condition.field);
                    var $condition = $('<div class="azh-cell azh-condition"></div>').appendTo($row);
                    $('<select><option value="is">is</option><option value="is not">is not</option><option value="greater than">greater than</option><option value="less than">less than</option><option value="contains">contains</option></select>').appendTo($condition).on('change', function() {
                        condition.condition = $(this).val();
                        $textarea.val(JSON.stringify(logic).replace(/\"/g, "'"));
                    }).val(condition.condition);

                    var $field = $('<div class="azh-cell azh-value"></div>').appendTo($row);
                    $('<input type="text" value="' + condition.value + '">').appendTo($field).on('change', function() {
                        condition.value = $(this).val();
                        $textarea.val(JSON.stringify(logic).replace(/\"/g, "'"));
                    });
                    $('<div class="azh-cell azh-remove"></div>').appendTo($row).on('click', function() {
                        logic.conditions.splice(i, 1);
                        $textarea.val(JSON.stringify(logic).replace(/\"/g, "'"));
                        refresh_table();
                    });
                }
                function refresh_table() {
                    $table.empty();
                    for (var i = 0; i < logic.conditions.length; i++) {
                        add_condition(i);
                    }
                }
                function mode_change() {
                    logic.mode = $modes.find(':checked').attr('id');
                    $textarea.val(JSON.stringify(logic).replace(/\"/g, "'"));
                }
                var $form = $element.closest('form, [data-section]');
                var $textarea = $modal.find('textarea[name="data-conditional-logic"]');
                $textarea.get(0).style.setProperty('display', 'none', 'important');
                var logic = $textarea.val().replace(/\'/g, '"');
                if (logic) {
                    logic = JSON.parse(logic);
                } else {
                    logic = {
                        mode: 'show-if-all',
                        conditions: []
                    };
                }

                var $logic = $('<div class="azh-logic"></div>').insertAfter($textarea);
                var $modes = $('<div class="azh-modes"></div>').appendTo($logic);
                $('<div class="azh-mode"><input id="show-if-all" type="radio" name="logic-mode" ' + ((logic.mode == 'show-if-all') ? 'checked' : '') + '><label for="show-if-all">' + azh.i18n.show_if_all + '</label></div>').appendTo($modes).on('change', mode_change);
                $('<div class="azh-mode"><input id="show-if-any" type="radio" name="logic-mode" ' + ((logic.mode == 'show-if-any') ? 'checked' : '') + '><label for="show-if-any">' + azh.i18n.show_if_any + '</label></div>').appendTo($modes).on('change', mode_change);
                $('<div class="azh-mode"><input id="hide-if-all" type="radio" name="logic-mode" ' + ((logic.mode == 'hide-if-all') ? 'checked' : '') + '><label for="hide-if-all">' + azh.i18n.hide_if_all + '</label></div>').appendTo($modes).on('change', mode_change);
                $('<div class="azh-mode"><input id="hide-if-any" type="radio" name="logic-mode" ' + ((logic.mode == 'hide-if-any') ? 'checked' : '') + '><label for="hide-if-any">' + azh.i18n.hide_if_any + '</label></div>').appendTo($modes).on('change', mode_change);
                $('<div class="azh-add"></div>').appendTo($logic).on('click', function() {
                    var $first_field = $form.find('[name]:not([name="' + $element.find('[name]').attr('name') + '"])').first();
                    var condition = {
                        field: $first_field.attr('name'),
                        condition: 'is',
                        value: ''
                    };
                    logic.conditions.push(condition);
                    add_condition(logic.conditions.length - 1);
                    $textarea.val(JSON.stringify(logic).replace(/\"/g, "'"));
                });
                var $table = $('<div class="azh-table"></div>').appendTo($logic);
                refresh_table();
            }
        },
        {
            "refresh": true,
            "menu": 'utility',
            "button_text": "Calculation formula",
            "button_class": "azh-calculation",
            "button_type": "azh-calculation",
            "title": "Calculation formula",
            "selector": 'form input[type="text"], form input[type="hidden"]:not([name="form_title"]), form [data-element="general/text.htm"], [data-calculation], form .az-paypal',
            "type": "textarea",
            "attribute": 'data-calculation',
            "callback": function($element, $modal) {
                function insertAtCursor(myField, myValue) {
                    //IE support
                    if (document.selection) {
                        myField.focus();
                        var sel = document.selection.createRange();
                        sel.text = myValue;
                    }
                    //MOZILLA and others
                    else if (myField.selectionStart || myField.selectionStart == '0') {
                        var startPos = myField.selectionStart;
                        var endPos = myField.selectionEnd;
                        myField.value = myField.value.substring(0, startPos)
                                + myValue
                                + myField.value.substring(endPos, myField.value.length);
                    } else {
                        myField.value += myValue;
                    }
                }
                var $form = $element.closest('form, [data-section]');
                var fields = {};
                $form.find('[name]:not([name="' + $element.find('[name]').attr('name') + '"])').each(function() {
                    var $this = $(this);
                    if ($this.children().length) {
                        $this.find('[value]').each(function() {
                            if ($(this).attr('value')) {
                                fields[$this.attr('name') + '=' + $(this).attr('value')] = $this.attr('name') + '=' + $(this).attr('value');
                            }
                        });
                    } else {
                        if ($this.attr('value') && ($this.is('[type="radio"]') || $this.is('[type="checkbox"]'))) {
                            fields[$this.attr('name') + '=' + $this.attr('value')] = $this.attr('name') + '=' + $this.attr('value');
                        } else {
                            fields[$this.attr('name')] = $this.attr('name');
                        }
                    }
                });
                var $textarea = $modal.find('textarea[name="data-calculation"]');
                var $names = $('<div class="azh-form-names"></div>').insertBefore($textarea);
                for (var name in fields) {
                    $('<a href="#" class="azh-form-name">{' + name + '}</a>').appendTo($names).on('click', function() {
                        insertAtCursor($textarea.get(0), $(this).text());
                        return false;
                    });
                }
            }
        },
        {
            "menu": 'utility',
            "button_text": "PayPal item name",
            "button_class": "azh-item-name",
            "button_type": "azh-item-name",
            "title": "PayPal item name",
            "selector": 'form .az-paypal .az-item-name',
            "type": "textarea",
            "attribute": 'value'
        }
    ]);
})(window.jQuery);