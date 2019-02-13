<?php
/**
 * The main template file for the frontpage of the site
 *
 * This is the custom frontpage for the demo company website.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package democompany
 */

    get_header();
?>

   <?php
      $carousel_custom_query = new WP_Query(array(
         'posts_per_page'        => 4,
         'post_type'             => 'carousel_post',
         'order'                 => 'ASC'
      ));

      if(!$carousel_custom_query->have_posts()) {
         echo '<h1>Nothing to Display</h1>';
      }else{
         echo '<div id="carousel-container" class="container-fluid carousel slide" data-ride="carousel">
                  <div class="container carousel-inner">';
      }
      $count = 0;
      while($carousel_custom_query->have_posts()) {

         $carousel_custom_query->the_post();
         $count++;

   ?>


         <div class="carousel-item img-holder <?php if($count==1) echo 'active'; ?>">
            <?php
               if(has_post_thumbnail()) {
                  the_post_thumbnail('post-thumbnail', ['class' => 'd-block w-100', 'alt'=>get_the_title()]);
               }else{
                  $args = array(
                     'numberposts'     => 1,
                     'order'           => 'DESC',
                     'post_mime_type'  => 'image',
                     'post_parent'     => get_the_ID(),
                     'post_type'       => 'attachment'

                  );

                  $images_in_post_array = get_children($args, ARRAY_A);

                  if($images_in_post_array) {
                     $images_in_post_array_with_number_keys = array_values($images_in_post_array);
                     $first_image  = $images_in_post_array_with_number_keys[0];
                     echo wp_get_attachment_image($first_image['ID'], array('900', '300') );
                  }else{
                     echo '<img width="960" height="300" src="" alt="No Image can be related to this post" />';
                  }

               }
            ?>
            <!-- <img src=<?php //the_post_thumbnail(); ?> alt=<?php //get_the_title(); ?> class="d-block w-100" /> -->
            <div class="carousel-caption d-none d-md-block">
               <h2 class="caption-head"><?php the_title(); ?></h2>
               <div class="caption-body"><?php has_excerpt() ? the_excerpt() : wp_trim_words(get_the_content(), 22); ?></div>
            </div>
         </div>

   <?php } //end-while

      if($count>0) {
   ?>
         <!-- Show the Controls if carousel is displayed -->
         <a href="#carousel-container" class="carousel-control-next" role="button" data-slide="next">
            <span class="carousel-control carousel-control-next-icon" aria-hidden="true">
               <svg version="1.0" class="carousel-svg-next" xmlns="http://www.w3.org/2000/svg" width="60.000000pt" height="60.000000pt" viewBox="0 0 60.000000 60.000000" preserveAspectRatio="xMidYMid meet">
                  <g transform="translate(0.000000,60.000000) scale(0.100000,-0.100000)" stroke="none">
                     <path d="M11 554 c13 -30 294 -514 299 -514 8 0 281 512 277 517 -2 2 -64 -42 -137 -97 -73 -55 -137 -100 -142 -100 -5 0 -68 42 -141 93 -154 109 -161 113 -156 101z"/>
                  </g>
               </svg>
            </span>
            <span class="sr-only">Next</span>
         </a>
         <a href="#carousel-container" class="carousel-control-prev" role="button" data-slide="prev">
            <span class="carousel-control carousel-control-prev-icon" aria-hidden="true">
               <!-- <i class="fas fa-less-than"></i> -->
               <svg version="1.0" class="carousel-svg-previous" xmlns="http://www.w3.org/2000/svg" width="60.000000pt" height="60.000000pt" viewBox="0 0 60.000000 60.000000" preserveAspectRatio="xMidYMid meet">
                  <g transform="translate(0.000000,60.000000) scale(0.100000,-0.100000)" stroke="none">
                     <path d="M11 554 c13 -30 294 -514 299 -514 8 0 281 512 277 517 -2 2 -64 -42 -137 -97 -73 -55 -137 -100 -142 -100 -5 0 -68 42 -141 93 -154 109 -161 113 -156 101z"/>
                  </g>
               </svg>
            </span>
            <span class="sr-only">Previous</span>
         </a>

         <!-- open ordered list to hold the indicators -->
         <ol class="carousel-indicators">
            <?php
               for($i=0; $i<$count; $i++) {
                  $acive_indicator = $i==0 ? 'class="active"' : '';
                  echo '<li data-target="#carousel-container" data-slide-to="' .  $i . '"' . $acive_indicator . '></li>';
               }
            ?>
         </ol>
      </div> <!--closing div tags for the carousel holder -->
   </div> <!--closing div tags for the container  -->
   <?php
      }//end if

?>

<div class="children-pages-holder container">
   <div class="lists-wrapper">
      <?php
         wp_reset_postdata();
         $child_pages_query_args = array(
            'post_type'       => 'page',
            'post_parent'     => get_option('page_on_front'),
            'order_by'        => 'menu_order',
         );

         $child_pages = new WP_Query($child_pages_query_args);

         if($child_pages->have_posts()) {
            echo '<ul class="children-lists no-bullet home-lists">'; //open up <ul> if there are children pages
            while($child_pages->have_posts()){
               $child_pages->the_post();

               $parent_id = get_the_ID(); //hold the id of the child in case we need it to check for granchildren
               $grand_children = get_pages('child_of=' . $parent_id);
               if(!count($grand_children)>0) {
                  echo '<li class="homepage-child"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';
               }else{
               ?>
                  <li class="homepage-child holds-homepage-grandchildren" data-id="<?php echo $parent_id ?>">
                     <a class="parent-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                     <svg version="1.0" class="carousel-svg-next reveal-pages" xmlns="http://www.w3.org/2000/svg" width="60.000000pt" height="60.000000pt" viewBox="0 0 60.000000 60.000000" preserveAspectRatio="xMidYMid meet">
                        <g transform="translate(0.000000,60.000000) scale(0.100000,-0.100000)" stroke="none">
                           <path d="M11 554 c13 -30 294 -514 299 -514 8 0 281 512 277 517 -2 2 -64 -42 -137 -97 -73 -55 -137 -100 -142 -100 -5 0 -68 42 -141 93 -154 109 -161 113 -156 101z"/>
                        </g>
                     </svg>
                     <!-- <i class="fa fa-less-than reveal-pages angle-down"></i> -->
                     <ul class="grandchildren-lists no-bullet home-lists" data-parentid="<?php echo $parent_id ?>"> <!-- ul tag to hold grandchildren -->
                        <?php
                           wp_reset_postdata();
                           $grandchildren_pages_query_args = array(
                              'post_type'       => 'page',
                              'post_parent'     => $parent_id,
                              'order_by'        => 'menu_order',
                           );
                           $grandchildren = new WP_Query($grandchildren_pages_query_args);

                           while($grandchildren->have_posts()){
                              $grandchildren->the_post();
                        ?>
                        <li class="grandchild">
                           <div  class="grandchild-page-img"><?php the_post_thumbnail(); ?></div>
                           <div class="grandchild-page-body">
                              <h2><?php the_title(); ?></h2>
                              <div  class="grandchild-page-content"><p><?php echo has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 18); ?></p></div>
                           </div>
                        </li>
                        <hr />
                        <?php } //end while (for grandchildren pages) ?>
                     </ul>
                  </li>
               <?php  } //end if (for grandchildren pages) ?>
         <?php
            } //end whle (for children pages)
            echo '</ul>';
         } //end if (for children pages)
      ?>
   </div>
</div>

<div class="container-fluid widget-homepage">
         <?php get_sidebar(); ?>
</div>






<?php get_footer();
