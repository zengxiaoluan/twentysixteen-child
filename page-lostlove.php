<?php
/**
 * Template Name: Lost love
 * 
 * created at 2020-07-11
 */

get_header(); ?>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.27.0/moment.min.js"></script>

<script src="<?php echo get_stylesheet_directory_uri() . '/dist/lost-love.js?'.date('s');?>"></script>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php
        // Start the loop.
        while ( have_posts() ) : the_post();

            // Include the page content template.
            get_template_part( 'template-parts/content', 'page' );

            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) {
                comments_template();
            }

            // End of the loop.
        endwhile;
        ?>

        <div id="lost-love">

        <display-love v-for='item,index in allEvents' :key="item.happenedAt" v-if="item.event" :index="index" :event="item.event" :happened-at="item.happenedAt" :count-down="item.countDown"></display-love>

<div id="template" class='template'>
    <input v-model="event" type="text" placeholder='事件，如：第一次牵手时间'>
    <input v-model="date" type="datetime-local" placeholder='Happened time'>
    <input id="add-moment" type="button" value='Add' @click="add">
</div>

</div>

<script type="text/x-template" id="display-love">
    <div class='event-item'>
        <dl>
            <dt>{{index+1}}, {{event}}</dt>
            <dd>时间发生在：{{happenedAt}}</dd>
            <dd>离现在已经过去了：{{countDown}}</dd>
        </dl>
    </div>
</script>

    </main><!-- .site-main -->

    <?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<style>
   .template{
       display:flex;
   }
   .event-item{
       border: 2px dashed pink;
       margin-bottom:1em;
   }
</style>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
