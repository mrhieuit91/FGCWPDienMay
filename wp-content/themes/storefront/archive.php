<?php
$categories = get_the_category();
$category_id = $categories[0]->cat_ID;
$posts_per_page = 5;
$page = isset($_REQUEST['page']) ? ((int) $_REQUEST['page']) : 1;
$offset = ($page - 1) * $posts_per_page;
$args = array(
    'posts_per_page' => $posts_per_page,
    'offset' => $offset,
    'category' => $category_id,
    'category_name' => '',
    'orderby' => 'date',
    'order' => 'DESC',
    'include' => '',
    'exclude' => '',
    'meta_key' => '',
    'meta_value' => '',
    'post_type' => 'post',
    'post_mime_type' => '',
    'post_parent' => '',
    'author' => '',
    'author_name' => '',
    'post_status' => 'publish',
    'suppress_filters' => true
);

$posts_array = get_posts($args);

if ($page === 1) :
    ?>
    </head>
    <div id="pageNews">
        <?php get_header(); ?>
        <script language="javascript">
            jQuery(document).ready(function ($) {
                var page = 1;
                $("#informationPost").hide();
                $(window).scroll(function () {
                    if (window.innerHeight + $(window).scrollTop() == $(document).height()){
                          $("#loading").show();
                    page++;
                    $.get(window.location.href+"&page=" + page, function (data) {
                        $("#loading").hide();
                        $(".post:last").after(data);
                        $("#post").hide();
                        $("#informationPost").show();
                    });

                    }
                      
                });

            });

        </script>
        <div id="contentSidebar" class="widget-area" role="complementary">
            <?php dynamic_sidebar('sidebar-1'); ?>

        </div> <!--end Sidebar-->
        <div id="ContentNews">
            <?php
            foreach ($posts_array as $key => $value) {
                global $post;
                $post = $value;
                ?>
                <!--Nội dung một bài viết-->
                <article <?php post_class() ?>  >
                    <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
                    <summary>
                        <?php the_content(); ?>
                    </summary>
                    <footer>
                        <?php the_tags(); ?>
                    </footer>
                </article>
                <!--kết thúc nội dung-->
                <?php
            }
            ?> 

        </div><!--end ContentNews-->

        <div class="content">
            <?php
            $args = array(
                'cat' => $category_id,
                'post_type' => 'post'
            );
            $the_query = new WP_Query($args);
            $numberPost = $the_query->found_posts;
            $numberPage = ceil($numberPost / 5);
            if ($numberPage > 1) {
                ?>
                <div id='loading' style="display:none; "><img src="images\loading.gif" alt="Image loading..." width="100" height="50"/>
                </div>
                <input type="button" name="clickme" id="post" value=""/>
            <?php } ?>
        </div>
        <?php
        //$count_posts = wp_count_posts();
        //$total_posts = $count_posts->publish;
        //echo $total_posts . ' Bài viết';
        ?>
        <div id="informationPost"> 
            <?php
            echo 'Đã hết dữ liệu';
            ?>
        </div>
    </div>

    <?php
    get_footer();
    ?>

    <?php
else :
    ?>

    <div>
        <?php
        foreach ($posts_array as $key => $value) {
            global $post;
            $post = $value;
            setup_postdata($post);
            ?>
            <!--Nội dung một bài viết-->
            <article <?php post_class() ?> >
                <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
                <summary>
                    <?php the_content(); ?>
                </summary>
                <footer>
                    <?php the_tags(); ?>
                </footer>
            </article>
            <!--kết thúc nội dung-->
            <?php
        }
        wp_reset_postdata();
        ?> 

    <?php
    endif;
    ?>
