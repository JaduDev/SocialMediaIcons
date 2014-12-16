<?php
    // Disallow direct access to this script. Should be include only
    if ($_SERVER['PHP_SELF'] == '/jadu/websections/' . __FILE__) {
        exit;
    }

    require_once('websections/JaduPageSupplements.php');
    require_once('websections/JaduPageSupplementLocations.php');
    require_once('websections/JaduPageSupplementWidgetPublicCode.php');
    require_once($widget->classFile);
    
    $locations = getAllSupplementLocations();
    
    if ($supplementRecordID > 0) {        
        $socialMediaIconsSupplement = getCustomSocialMediaIcons($supplementRecordID);
    }
    else {
        $socialMediaIconsSupplement = new SocialMediaIcons();
    }
    
    if (isset($_POST['save'])) {


        $socialMediaIconsSupplement->title = isset($_POST['title']) ? $_POST['title'] : $socialMediaIconsSupplement->title;
        $socialMediaIconsSupplement->url_facebook = isset($_POST['url_facebook']) ? $_POST['url_facebook'] : $socialMediaIconsSupplement->url_facebook;
        $socialMediaIconsSupplement->url_twitter = isset($_POST['url_twitter']) ? $_POST['url_twitter'] : $socialMediaIconsSupplement->url_twitter;
        $socialMediaIconsSupplement->url_vimeo = isset($_POST['url_vimeo']) ? $_POST['url_vimeo'] : $socialMediaIconsSupplement->url_vimeo;
        $socialMediaIconsSupplement->url_youtube = isset($_POST['url_youtube']) ? $_POST['url_youtube'] : $socialMediaIconsSupplement->url_youtube;
        $socialMediaIconsSupplement->url_googleplus = isset($_POST['url_googleplus']) ? $_POST['url_googleplus'] : $socialMediaIconsSupplement->url_googleplus;
        $socialMediaIconsSupplement->url_linkedin = isset($_POST['url_linkedin']) ? $_POST['url_linkedin'] : $socialMediaIconsSupplement->url_linkedin;
        $socialMediaIconsSupplement->url_wordpress = isset($_POST['url_wordpress']) ? $_POST['url_wordpress'] : $socialMediaIconsSupplement->url_wordpress;
        $socialMediaIconsSupplement->url_blogspot = isset($_POST['url_blogspot']) ? $_POST['url_blogspot'] : $socialMediaIconsSupplement->url_blogspot;

        // Validate the supplement
        $errors = validateSocialMediaIconsSupplement($socialMediaIconsSupplement);
        
        if ($editType == 'supplement' || $_GET['contentType'] != '') {
            // Get the location and validate it, only for supplement editing though
            $locationOnPage = isset($_POST['locationOnPage']) ? strtolower($_POST['locationOnPage']) : '';
            $locationIsValid = false;
            if ($locationOnPage != '') {
                foreach ($locations as $location) {
                    if (strtolower($location->title) == $locationOnPage) {
                        $locationIsValid = true;
                    }
                }
            }
        
            if (!$locationIsValid) {
                $errors['locationOnPage'] = true;
            }
        }
        
        if (count($errors) == 0) {
            if ($socialMediaIconsSupplement->id < 1) {
                $socialMediaIconsSupplement->id = newSocialMediaIconsSupplement($socialMediaIconsSupplement);
            }
            else {
                updateSocialMediaIconsSupplement($socialMediaIconsSupplement);
            }
            
            
            if ($editType == 'supplement' || $_GET['contentType'] != '') {
                deleteAllCategoriesForSupplement($socialMediaIconsSupplement->id);

                $supplementCategory = new SupplementCategory();
                $supplementCategory->categoryID = getFirstCategoryIDForItemOfType ($contentTypeCatTable, ($contentType == 'document')?$documentID:$itemID);
                $supplementCategory->supplementRecordID = $socialMediaIconsSupplement->id;
                $supplementCategory->supplementWidgetID = $widget->id;
                newSupplementCategory($supplementCategory);

                if ($pageSupplement->id > 0) {
                    if ($pageSupplement->locationOnPage != $locationOnPage) {
                        // Get the new position for the new location
                        $pageSupplement->position = getMaxPageSupplementPosition($pageSupplement->contentType, $pageSupplement->itemID, $locationOnPage);

                        // Reorder the remaining supplements at the old location
                        fixPageSupplementPositions($pageSupplement->contentType, $pageSupplement->itemID);

                        $pageSupplement->locationOnPage = $locationOnPage;
                    }
                    $pageSupplement->supplementRecordID = $socialMediaIconsSupplement->id;
                    updatePageSupplement($pageSupplement);
                }
                else {
                    $pageSupplement = new PageSupplement();
                    $pageSupplement->contentType = $contentType;
                    $pageSupplement->itemID = $itemID;
                    $pageSupplement->supplementWidgetID = $widget->id;
                    $pageSupplement->supplementRecordID = $socialMediaIconsSupplement->id;
                    $pageSupplement->locationOnPage = $locationOnPage;
                    $pageSupplement->id = newPageSupplement($pageSupplement);
                }
                
                header('Location: supplement_list.php?contentType=' . $pageSupplement->contentType . '&itemID=' . $pageSupplement->itemID . '&location=' . $pageSupplement->locationOnPage . '&statusMessage=' . urlencode('Supplement saved'));
                exit;
            }
            else {
                header('Location: supplement_record_list.php?widgetID=' . $widget->id . '&statusMessage=' . urlencode('Supplement saved'));
                exit;
            }
        }
    }
    
    $supplementRecords = getAllSocialMediaIconsSupplements(array());
    $imageDirectory = $SECURE_SERVER . '/images/';

    // The start of the table is output before this script is included so error message is always output but hidden
    if (isset($errors) && count($errors) > 0) {
?>
    <script type="text/javascript">
        $('validate_mssg').show();
    </script>
<?php
    }

    if ($editType == 'supplement' || (isset($_GET['contentType']) && $_GET['contentType'] != '')) {
?>
        <tr>
            <td class="generic_desc"><em><?php print $stepCounter++; ?>.</em> <p>Select existing</p></td>
            <td class="generic_action">
                <select class="select" onchange="selectNav(this);">
                    <option value="supplement_details.php?supplementRecordID=-1&amp;supplementID=-1&amp;widgetID=<?php print (int) $widget->id; ?>&amp;contentType=<?php print encodeHtml($contentType); ?>&amp;itemID=<?php print (int) $itemID; ?>&amp;location=<?php print encodeHtml($locationOnPage); ?>">Create new supplement</option>
<?php
                foreach ($supplementRecords as $supplementRecord) {
                    if (adminCanAccessSupplement($supplementRecord->id, $adminID)) {
                        $selected = '';
                        if ($supplementRecordID == $supplementRecord->id) {
                            $selected = ' selected="selected"';
                        }
?>
                        <option value="supplement_details.php?supplementRecordID=<?php print (int) $supplementRecord->id; ?>&amp;supplementID=<?php print (int) $pageSupplement->id; ?>&amp;widgetID=<?php print (int) $widget->id; ?>&amp;contentType=<?php print encodeHtml($contentType); ?>&amp;itemID=<?php print (int) $itemID; ?>&amp;location=<?php print encodeHtml($locationOnPage); ?>"<?php print $selected; ?>><?php print encodeHtml($supplementRecord->title); ?></option>
<?php
                    }
                }
?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="generic_desc<?php if (isset($errors['locationOnPage'])) { ?>_error<?php } ?>"><em><?php print $stepCounter++; ?>.</em> <p>Placement</p></td>
            <td class="generic_action">
                <select class="select" name="locationOnPage">
<?php
                foreach ($locations as $locationItem) {
                    $publicCode = getSupplementPublicCode($widget->id, $locationItem->title);
                    if ($publicCode->id == -1) {
                        continue;
                    }
                
                    $selected = '';
                    if ((isset($_POST['save']) && $locationOnPage == strtolower($locationItem->title)) || 
                        ($pageSupplement->locationOnPage == strtolower($locationItem->title))) {
                        $selected = ' selected="selected"';
                    }
                    else if ($_GET['location'] == strtolower($locationItem->title)) {
                        $selected = ' selected="selected"';
                    }
?>
                    <option value="<?php print encodeHtml($locationItem->title); ?>"<?php print $selected; ?>><?php print encodeHtml($locationItem->title); ?></option>
<?php
                }
?>
                </select>
            </td>
        </tr>
<?php
    }
?>
        <tr>
            <td class="generic_desc<?php if (isset($errors['title'])) { ?>_error<?php } ?>"><em><?php print $stepCounter++; ?>.</em> <p>Title*</p></td>
            <td class="generic_action">
                <input type="text" name="title" size='65' value="<?php print encodeHtml($socialMediaIconsSupplement->title); ?>" class="field" />
            </td>
        </tr>

        <tr>
            <td class="generic_desc"><em><?php print $stepCounter++; ?>.</em> <p>Facebook URL</p></td>
            <td class="generic_action">
                <input type="text" name="url_facebook" size='65' value="<?php print encodeHtml($socialMediaIconsSupplement->url_facebook); ?>" class="field" />
            </td>
        </tr>
        <tr>
            <td class="generic_desc"><em><?php print $stepCounter++; ?>.</em> <p>Twitter URL</p></td>
            <td class="generic_action">
                <input type="text" name="url_twitter" size='65' value="<?php print encodeHtml($socialMediaIconsSupplement->url_twitter); ?>" class="field" />
            </td>
        </tr>
        <tr>
            <td class="generic_desc"><em><?php print $stepCounter++; ?>.</em> <p>Vimeo URL</p></td>
            <td class="generic_action">
                <input type="text" name="url_vimeo" size='65' value="<?php print encodeHtml($socialMediaIconsSupplement->url_vimeo); ?>" class="field" />
            </td>
        </tr>
        <tr>
            <td class="generic_desc"><em><?php print $stepCounter++; ?>.</em> <p>YouTube URL</p></td>
            <td class="generic_action">
                <input type="text" name="url_youtube" size='65' value="<?php print encodeHtml($socialMediaIconsSupplement->url_youtube); ?>" class="field" />
            </td>
        </tr>
        <tr>
            <td class="generic_desc"><em><?php print $stepCounter++; ?>.</em> <p>Google Plus URL</p></td>
            <td class="generic_action">
                <input type="text" name="url_googleplus" size='65' value="<?php print encodeHtml($socialMediaIconsSupplement->url_googleplus); ?>" class="field" />
            </td>
        </tr>
        <tr>
            <td class="generic_desc"><em><?php print $stepCounter++; ?>.</em> <p>linkedIn URL</p></td>
            <td class="generic_action">
                <input type="text" name="url_linkedin" size='65' value="<?php print encodeHtml($socialMediaIconsSupplement->url_linkedin); ?>" class="field" />
            </td>
        </tr>
        <tr>
            <td class="generic_desc"><em><?php print $stepCounter++; ?>.</em> <p>Wordpress URL</p></td>
            <td class="generic_action">
                <input type="text" name="url_wordpress" size='65' value="<?php print encodeHtml($socialMediaIconsSupplement->url_wordpress); ?>" class="field" />
            </td>
        </tr>
        <tr>
            <td class="generic_desc"><em><?php print $stepCounter++; ?>.</em> <p>Blogspot URL</p></td>
            <td class="generic_action">
                <input type="text" name="url_blogspot" size='65' value="<?php print encodeHtml($socialMediaIconsSupplement->url_blogspot); ?>" class="field" />
            </td>
        </tr>
              
        <tr>
            <td colspan="2" class="generic_finish"><em><?php print $stepCounter++; ?>.</em>
                <span><input type="submit" class="button" name="save" value="Save Supplement" /></span> 
            </td>
        </tr>