<?php
/*
 * Admin tab: Demos.
 * Creates demo posts: template + items.
 */
function abcfsl_admin_demos() {

    $obj = ABCFSL_Main();
    $slug = $obj->pluginSlug;

    echo  abcfl_html_tag('div', '', 'wrap' );
    echo abcfl_html_tag( 'h3', '', '' );
    echo abcfsl_txta(294);
    echo abcfl_html_tag_end('h3');

    if ( isset($_POST['btnAddDefaultPosts']) ){
        check_admin_referer( $slug . '_nonce' );

        $insertStatus = abcfsl_admin_demos_add_default_pages();

        $defaults = array( 'errorMsg' => 'M', 'outTplate' => 'T', 'outItem1' => '1', 'outItem2' => '2', 'outItem3' => '3' );
        $out = wp_parse_args( $insertStatus, $defaults );

        //Return status messages.
        if($insertStatus['status'] == 'KO') {
            echo abcfl_input_info_lbl( $out['errorMsg'], 'abcflMTop15 abcflRed', 16, 'SB' );
        }
         echo abcfl_input_info_lbl($out['outTplate'], 'abcflMTop15', 14, 'SB');
         echo abcfl_input_info_lbl($out['outItem1'], 'abcflMTop10', 14, 'SB');
         echo abcfl_input_info_lbl($out['outItem2'], 'abcflMTop10', 14, 'SB');
         echo abcfl_input_info_lbl($out['outItem3'], 'abcflMTop10', 14, 'SB');
    }
    //------------------------------------------------------------
    echo abcfl_html_form( 'frm-mm-defaults', '');
    wp_nonce_field($slug . '_nonce');
   //-------------------------------------------------------------
    //-- Main Cntr DIV Start --------------
    echo abcfl_html_tag_cls('div', 'abcflMTop20 abcflMLeft30');
    echo abcfl_input_hline('2', '20', '50P');

    echo abcfl_html_tag('div','', 'submit' );
    echo abcfl_input_btn( 'btnAddDefaultPosts', 'btnAddDefaultPosts', 'submit', abcfsl_txta(241), 'button-primary abcficBtnWide' );

    //-- ENDs: Button, Main Cntr, Form,  ------------------------------------------------
    echo abcfl_html_tag_ends('div,div,form');
}

function abcfsl_admin_demos_add_default_pages() {

    $cptTtplate = 'cpt_staff_lst';
    $titleTplate = 'Staff Template Demo';
    $cptItem = 'cpt_staff_lst_item';
    $errMsgInsertFailed = 'Error: Demo records insert failed!';

    $insertStatus['status'] = 'OK';
    $insertStatus['errorMsg'] = '';
    $sufix = '';

    //--CHECK CUSTOM POST TYPES ------------------------------------
    $outPostType = abcfsl_admin_demos_check_post_type( $cptTtplate );
    if( !$outPostType ) {
        $insertStatus['status'] = 'KO';
        $insertStatus['errorMsg'] = 'Error: Custom post type doesn\'t exist: ' . $cptTtplate;
        return $insertStatus;
    }

    $outPostType = abcfsl_admin_demos_check_post_type( $cptItem );
    if( !$outPostType ) {
        $insertStatus['status'] = 'KO';
        $insertStatus['errorMsg'] = 'Error: Custom post type doesn\'t exist: ' . $cptItem;
        return $insertStatus;
    }
    //---------------------------------------------

    //-- CREATE TEMPLATE --------------------------
    //Check if custom post type with the same name already exists. If so append suffix
    $pgExists = abcfsl_admin_demos_check_post_title( $cptTtplate, $titleTplate );
    if( $pgExists ){
        $sufix = rand( 1 , 100 );
        $titleTplate .= ' ' . $sufix;
    }

    $errTplate = 'Error: Staff Template Demo not created.';
    $outTplate = abcfsl_admin_demos_create_template( $cptTtplate, $titleTplate, $errTplate );
    if( empty( $outTplate ) ) {
        $insertStatus['status'] = 'KO';
        $insertStatus['errorMsg'] = $errMsgInsertFailed;
        $insertStatus['outTplate'] = $errTplate;
        return $insertStatus;
    }
    if( $outTplate['status'] == 'KO' ) {
        $insertStatus['status'] = 'KO';
        $insertStatus['errorMsg'] = $errMsgInsertFailed;
        $insertStatus['outTplate'] = $outTplate['outTplate'];
        return $insertStatus;
    }

    $insertStatus['outTplate'] = $outTplate['outTplate'];

    //-- CREATE ITEMS --------------------------
    $parItem['tplateID'] = $outTplate['tplateID'];
    $parItem['sufix'] = $sufix;
    $parItem['cptItem'] = $cptItem;
    $parItem['errorMsg'] = 'Error: Staff Member Demo not created.';
    $parItem['errMsgInsertFailed'] = $errMsgInsertFailed;

    //------------------------------------------------
    $parItem['recordNo'] = '1';
    $insertStatus = abcfsl_admin_demos_item_bldr( 'Stephanie More', 'Assistant Principal', '123-5555-2323', 'Email myemail@mydomain.com', $parItem, $insertStatus);
    if( $insertStatus['status'] != 'OK' ) { return $insertStatus; }
    //------------------------------------------------
    $parItem['recordNo'] = '2';
    $insertStatus = abcfsl_admin_demos_item_bldr( 'Michael Gordon', 'Language Arts Teacher', '123-2828-2828', 'myemail@mydomain.com myemail@mydomain.com', $parItem, $insertStatus);
    if( $insertStatus['status'] != 'OK' ) { return $insertStatus; }
    //------------------------------------------------
    $parItem['recordNo'] = '3';
    $insertStatus = abcfsl_admin_demos_item_bldr( 'Laura Taylor', 'Social Studies Teacher', '989-6667-6262', 'Contact myemail@mydomain.com', $parItem, $insertStatus);
    if( $insertStatus['status'] != 'OK' ) { return $insertStatus; }

    return $insertStatus;
}

function abcfsl_admin_demos_item_bldr( $name, $position, $phone, $email, $par, $insertStatus){

    $par['name'] = $name;
    $par['position'] = $position;
    $par['phone'] = $phone;
    $par['email'] = $email;
    $par['title'] = 'Demo ' . $par['sufix'] . ' - ' . $name;

    $out = abcfsl_admin_demos_create_item( $par );

    if( empty( $out ) ) {
        $insertStatus['status'] = 'KO';
        $insertStatus['errorMsg'] = $par['errMsgInsertFailed'];
        return $insertStatus;
    }

    if( $out['status'] == 'KO' ) {
        $insertStatus['status'] = 'KO';
        $insertStatus['errorMsg'] = $par['errMsgInsertFailed'];
        $insertStatus['outItem' . $par['recordNo']] = $out['itemTitle'];
        return $insertStatus;
    }

    $insertStatus['outItem' . $par['recordNo']] = $out['itemTitle'];

    return $insertStatus;

}

function abcfsl_admin_demos_create_template( $postType, $titleTplate, $errTplate ) {

    $postData = array (
        'comment_status'    => 'closed',
        'ping_status'       => 'closed',
        'post_title'        => $titleTplate,
        'post_status'       => 'publish',
        'post_type'         => $postType,
    );

    $postID = wp_insert_post( $postData );

    $out['status'] = 'KO';
    $out['outTplate'] = $errTplate;
    $out['tplateID'] = 0;

    if ( is_wp_error( $postID ) ) {
        $out['status'] = 'KO';
        $out['outTplate'] = $postID->get_error_message();
        return $out;
    }
    if ( !$postID ) {
        $out['status'] = 'KO';
        $out['outTplate'] = $errTplate;
        return $out;
    }

    // insert post meta
    add_post_meta($postID, '_lstLayout', '1');
    add_post_meta($postID, '_lstLayoutH', '1');
    add_post_meta($postID, '_sortType', 'P');

    add_post_meta($postID, '_lstCols', '5');
    add_post_meta($postID, '_lstImgCls', 'abcfslImgCenter abcfslImgBorder1');

    add_post_meta($postID, '_spgCols', '5');
    add_post_meta($postID, '_spgImgCls', 'abcfslImgCenter abcfslImgBorder1');
    add_post_meta($postID, '_spgCntrCls', 'abcfslMB200');

    add_post_meta($postID, '_fieldType_F1', 'MP');
    add_post_meta($postID, '_fieldTypeH_F1', 'MP');
    add_post_meta($postID, '_showField_F1', 'Y');
    add_post_meta($postID, '_tagType_F1', 'h3');
    add_post_meta($postID, '_inputLblP1_F1', 'First Name');
    add_post_meta($postID, '_inputLblP2_F1', 'Last Name');
    add_post_meta($postID, '_orderLP1_F1', '2');
    add_post_meta($postID, '_orderLP2_F1', '1');
    add_post_meta($postID, '_orderSP1_F1', '1');
    add_post_meta($postID, '_orderSP2_F1', '2');
    add_post_meta($postID, '_inputHlp_F1', 'Enter staff member name.');

    add_post_meta($postID, '_fieldType_F2', 'T');
    add_post_meta($postID, '_fieldTypeH_F2', 'T');
    add_post_meta($postID, '_showField_F2', 'Y');
    add_post_meta($postID, '_tagType_F2', 'p');
    add_post_meta($postID, '_inputLbl_F2', 'Job Title');

    add_post_meta($postID, '_fieldType_F3', 'LT');
    add_post_meta($postID, '_fieldTypeH_F3', 'LT');
    add_post_meta($postID, '_showField_F3', 'Y');
    add_post_meta($postID, '_tagType_F3', 'p');
    add_post_meta($postID, '_lblTxt_F3', 'Phone: ');
    add_post_meta($postID, '_inputLbl_F3', 'Phone Number');
    add_post_meta($postID, '_inputHlp_F3', 'Enter office phone number.');

    add_post_meta($postID, '_fieldType_F4', 'EM');
    add_post_meta($postID, '_fieldTypeH_F4', 'EM');
    add_post_meta($postID, '_showField_F4', 'S');
    add_post_meta($postID, '_tagType_F4', 'p');
    add_post_meta($postID, '_lnkLblLbl_F4', 'Email Link Text');
    add_post_meta($postID, '_lnkLblHlp_F4', 'The link text is the visible part displayed on the page. Enter email address or any other text.');
    add_post_meta($postID, '_lnkUrlLbl_F4', 'Email Address');
    add_post_meta($postID, '_lnkUrlHlp_F4', 'Enter email address.');

    add_post_meta($postID, '_fieldType_F5', 'TH');
    add_post_meta($postID, '_fieldTypeH_F5', 'TH');
    add_post_meta($postID, '_showField_F5', 'L');
    add_post_meta($postID, '_tagType_F5', 'p');
    add_post_meta($postID, '_lblTxt_F5', 'Profile ');
    add_post_meta($postID, '_lnkUrlLbl_F5', 'Link to Single Page');
    add_post_meta($postID, '_lnkUrlHlp_F5', 'To create link to a Single Page enter: SP');

    $out['status'] = 'OK';
    $out['outTplate'] = 'Created: ' . $titleTplate;
    $out['tplateID'] = $postID;

    return $out;
}

function abcfsl_admin_demos_create_item( $par ) {

    $postData = array (
        'comment_status'    => 'closed',
        'ping_status'       => 'closed',
        'post_title'        => $par['title'],
        'post_status'       => 'publish',
        'post_type'         => $par['cptItem'],
        'post_parent'       => $par['tplateID']
    );

    $out['status'] = 'KO';
    $out['outItem'] = '';
    $out['itemID'] = 0;

    $postID = wp_insert_post( $postData );

    if ( is_wp_error( $postID ) ) {
        $out['status'] = 'KO';
        $out['outItem'] = $postID->get_error_message();
        return $out;
    }
    if (!$postID) {
        $out['status'] = 'KO';
        $out['outItem'] = $par['errorMsg'];
        return $out;
    }

    $recordNo = $par['recordNo'];
    $src = trailingslashit( ABCFSL_PLUGIN_URL ) . 'images/staff-member-'. $recordNo . '.jpg';

    // Add post meta
    add_post_meta($postID, '_imgIDL', '0');
    add_post_meta($postID, '_imgUrlL', $src);
    add_post_meta($postID, '_imgLnkL', 'SP');
    add_post_meta($postID, '_imgIDS', '0');
    add_post_meta($postID, '_imgUrlS', 'SP');

    $nameParts = explode(' ', $par['name'] );
    $emailParts = explode(' ', $par['email'] );

    add_post_meta($postID, '_mp1_F1', $nameParts[0]);
    add_post_meta($postID, '_mp2_F1', $nameParts[1]);
    add_post_meta($postID, '_txt_F2', $par['position']);
    add_post_meta($postID, '_txt_F3', $par['phone']);
    add_post_meta($postID, '_urlTxt_F4', $emailParts[0]);
    add_post_meta($postID, '_url_F4', $emailParts[1]);
    add_post_meta($postID, '_url_F5', 'SP');

    $out['status'] = 'OK';
    $out['itemTitle'] = 'Created: Staff Member ' . $par['title'];
    $out['itemID'] = $postID;

    return $out;
}

function abcfsl_admin_demos_check_post_type( $postType ) {

    if ( post_type_exists( $postType ) ) {
        return true;
    }
    return false;
}

function abcfsl_admin_demos_check_post_title( $postType, $pgTitle ) {

    $out = false;
    $pg = get_page_by_title( $pgTitle, 'OBJECT', $postType );
    if ($pg !== null) { $out = true; }
    return $out;
}

