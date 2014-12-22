<?php
  // fcd1, 9/6/13: get item id and title, store in variable 'caused reused
  $item_id = metadata('item','id');
  $item_title = metadata('item', array('Dublin Core', 'Title'));
?>

<?php
  echo head(array('title' => $item_title,
		  'bodyclass' => 'exhibits exhibit-item-show'));
?>

<div id="item-page-content">
  <div id="primary" class="show">
    <h3 class="exhibit-title-link">Exhibition: 
    <?php echo exhibit_builder_link_to_exhibit(null,null,array('class' => 'link-to-exhibit')); ?>
    </h3>
    <table>
      <tr>
        <td>
          <?php
            // fcd1, 01/31/14:
            // Retrieve, in an array, the list of exhibit pages containing the current item.
            $exhibit_pages = CulCustomizePlugin::return_exhibit_pages_containing_current_item();

            // fcd1, 01/31/14
            // Print out a link back to the exhibit page we came from.
            // The second parameter is set to TRUE to indicate this is a legacy exhibition
            $exhibit_page_containing_item = 
              CulCustomizePlugin::return_exhibit_page_to_link_back_to($exhibit_pages, TRUE);
            if ($exhibit_page_containing_item) {
	      $link_title = $exhibit->title.': ';
	      $parent_page = $exhibit_page_containing_item->getParent();
	      $link_title .= ( $parent_page ? $parent_page->title . ': ' : '');
              $link_title .= $exhibit_page_containing_item->title.'</a></p>';
              echo '<h3>View item in context</h3>';
              echo '<p><a href="'.
                html_escape(exhibit_builder_exhibit_uri($exhibit, $exhibit_page_containing_item)).
                '">'.$link_title.'</a></p>';
            }

            // fcd1, 01/31/14:
            // Print out a list of other exhibit pages containing the item
            // CulCustomizePlugin::display_links_to_exhibit_pages_containing_item takes
            // care of filtering out $exhibit_page_containing_item, since we already
            // displayed a link to that page
            if(!empty($exhibit_pages)) {
	      CulCustomizePlugin::display_links_to_exhibit_pages_containing_item(
										 $exhibit_pages,
										 $exhibit_page_containing_item);
	    }
          ?>
          <h1 class="item-title">Item Information</h1>

          <div id="item-files">
            <?php 
              // fcd1, 12/19/14: Following is defined in plugins/CulCustomized/CulCustomizePlugin
              // All this method does is call files_for_item with hard-coded arguments.
              cul_files_for_item();
            ?>

            <div id="item-feedback" class="element" style="padding-left:25px;">
              <h3>Send feedback on this item</h3>
              <?php if (!isset($_GET['submitted'])): ?>
                <div id="feedback-form">
                  <form method="post" action="http://www.columbia.edu/cgi-bin/generic-inbox.pl"
                        name="feedbackform" id="feedbackform">
                    <p><label for="name">Name:</label>
                      <input type="text" name="name" id="name" value="" />
                    </p>
                    <p><label for="email">Email:</label>
                      <input type="text" name="email" id="email" value="" />
                    </p>
                    <p><label for="feedback">Feedback:</label>
                      <textarea name="feedback" rows="1" cols="2"
                                id="feedback" style="width:200px;height:100px;"></textarea>
                    </p>
                    <input type="hidden" name="item_id" value="<?php echo $item_id; ?>" />
                    <input type="hidden" name="item_title" value="<?php echo $item_title; ?>" />
	            <?php
	              $ack_uri ='https://' . $_SERVER['SERVER_NAME'] . 
                                exhibit_builder_exhibit_item_uri(get_record_by_id('item',$item_id)) .
                                '?submitted=true';
                    ?>
                    <input type="hidden" name="ack_link" value="<?php echo $ack_uri; ?>" />
                    <input type="hidden" name="mail_dest" value="fcd1@columbia.edu" />
                    <input type="hidden" name="subject" 
                           value="Dramatic Museum Realia Feedback, Item : <?php echo $item_id;?>" />
                    <input type="hidden" name="echo_data" value="true" />
                    <?php
		     // fcd1, 9/6/13: comment out for now
		     /*
		      <input type="hidden" name="adminUrl" value="<?=WEB_ROOT . '/admin' . item_uri('edit')?>" />
		     */
		    ?>
                    <p style="text-align:center;"><input type="submit" value="Submit"
                       style="color:#fff;background:#77403e" />
                  </form><!--end id="feedbackform"-->
                </div><!--end id="feedback-form"-->
                <?php else: ?>
                <div id="result">
                  <?php
	            $ack_uri = "https://" . $_SERVER['SERVER_NAME'] . 
                               exhibit_builder_exhibit_item_uri(get_record_by_id('item',$item_id));
                  ?>
                  Thank you for your feedback.  We appreciate your interest in our collection.<br /><br />
                  <a href="<?php echo $ack_uri;?>">Send additional feedback&nbsp;&raquo;</a>

                </div><!--end id="result"-->
              <?php endif; ?>
            </div><!--end id="item-feedback"-->
          </div><!--end id="item-files"-->

          <?php echo all_element_texts('item'); ?>

          <?php if (metadata('item', 'has tags')): ?>
            <div class="tags">
              <h3><?php echo __('Tags'); ?></h3>
              <?php echo tag_string('item'); ?>
            </div><!--end class="tags"-->
          <?php endif;?>

          <div id="citation" class="field">
            <h3><?php echo __('Citation'); ?></h3>
            <p id="citation-value" class="field-value"><?php echo metadata('item', 'citation',
									   array('no_escape' => true)); ?>
            </p>
          </div><!--end id="citatiob"-->
        </td>
      </tr>
    </table>
  </div><!--end id="item-page-content"-->
</div><!--end id="primary"-->

<?php echo foot(); ?>
