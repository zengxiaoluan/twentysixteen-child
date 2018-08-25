<?php
/**
 * Template Name: Slides
 * Share Of Slides
 * created at 2018-01-24
 */

get_header('slides'); ?>
    <div id="loading" class="table">
        <div class="table-cell">
            <div class="lds-facebook"><div></div><div></div><div></div></div>
        </div>
    </div>

    <?php
    // Start the loop.
    while ( have_posts() ) : the_post();

        // Include the page content template.
        get_template_part( 'template-parts/content', 'slides' );

        // End of the loop.
    endwhile;
    ?>
    
    <style>
        .table {
            display: table;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            width: 100%;
            height: 100%;
            z-index: 2;
            background: aliceblue;
        }
        .table-cell {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }
        .lds-facebook {
          display: inline-block;
          position: relative;
          width: 64px;
          height: 64px;
        }
        .lds-facebook div {
          display: inline-block;
          position: absolute;
          left: 6px;
          width: 10px;
          background: #06f46c;
          animation: lds-facebook 1.2s cubic-bezier(0, 0.5, 0.5, 1) infinite;
        }
        .lds-facebook div:nth-child(1) {
          left: 6px;
          animation-delay: -0.24s;
        }
        .lds-facebook div:nth-child(2) {
          left: 26px;
          animation-delay: -0.12s;
        }
        .lds-facebook div:nth-child(3) {
          left: 45px;
          animation-delay: 0;
        }
        @keyframes lds-facebook {
          0% {
            top: 6px;
            height: 51px;
          }
          50%, 100% {
            top: 19px;
            height: 26px;
          }
        }
    </style>

    <link rel="stylesheet" href="https://alvarotrigo.com/fullPage/jquery.fullpage.min.css">
    <script>
        var $ = jQuery
    </script>
    <script src="https://cdn.bootcss.com/fullPage.js/2.9.5/vendors/scrolloverflow.min.js"></script>
    <script src="https://alvarotrigo.com/fullPage/jquery.fullPage.min.js"></script>
    <script>
        (function ($) {
            $(document).ready(function () {
              $('#primary').fullpage({
                sectionsColor: ['#f2f2f2', '#1bbc9b', '#ccddff', '#4BBFC3', '#7BAABE', 'whitesmoke'],
                controlArrows: false,
                anchors: ['slides', 'slides-comments', 'menu'],
                scrollOverflow: true,
                afterRender: function () {
                    $('#loading').fadeOut();
                }
              })
            })
        })(jQuery)
    </script>

<?php get_footer('slides'); ?>
