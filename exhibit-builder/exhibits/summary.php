      <?php echo head(array('title' => metadata('exhibit', 'title'), 'bodyclass'=>'exhibits summary')); ?>
      <div id="exhibit-nav">
        <ul class="exhibit-section-nav" style="padding:0; margin:0">
          <li>
            <?php
              $title = exhibit_builder_link_to_exhibit(get_current_record('exhibit'),
						       "Home",
						       array('class' => 'home_link'));
              echo $title;
            ?>
          </li>
        </ul>
        <ul class="exhibit-section-nav">
          <?php
            set_exhibit_pages_for_loop_by_exhibit();
            foreach (loop('exhibit_page') as $exhibitPage):
              $html = '<li>' . '<a href="' . 
              exhibit_builder_exhibit_uri(get_current_record('exhibit'), 
					  $exhibitPage) . '">' .
	      cul_insert_angle_brackets(metadata($exhibitPage, 'title')) . '</a></li>';
              echo $html;
            endforeach;
          ?>
        </ul>
      </div> <!--end id="exhibit-nav"-->
      <div id="content">
        <?php echo flash(); ?>
        <div id="solidBlock">
          <table style="border-collapse:collapse">
            <tr>
              <td style="border-right:5px solid #fff;vertical-align:middle;padding:10px;width:380px">
                <h1>
                  <span style="text-transform:none;font-size:24px">
                    <?php echo metadata('exhibit','title'); ?>
                  </span>
                </h1>
              </td>
              <td>
                <img src="<?=img('puppet-m.jpg')?>" alt="<?metadata('exhibit','title');?>">
              </td>
            </tr>
          </table>
        </div> <!--end id="solidBlock"-->
        <div class="exhibit-description">
          <?php echo $exhibit->description; ?>
        </div> <!--end class="exhibit-description"-->
        <div id="exhibit-credits">	
          <h3>Exhibit Curator</h3>
          <?php echo $exhibit->credits; ?>
        </div> <!--end id="exhibit-credits"-->
      </div> <!--end id="content"-->
    <?php echo foot(); ?>

