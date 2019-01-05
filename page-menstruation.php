<?php
/**
 * Template Name: Menstruation
 * created at 2019-01-05
 */

get_header(); ?>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    var currentYear = (new Date).getFullYear()
    var allData = allData || { // 防止页面没有初始数据的情况
        currentYear: []
    }
</script>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <?php
        // Start the loop.
        while ( have_posts() ) : the_post();

            // Include the page content template.
            get_template_part( 'template-parts/content', 'page' );

        ?>
        <div id="highcharts"></div>
        <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) {
                comments_template();
            }

            // End of the loop.
        endwhile;
        ?>
    </main>
    <?php get_sidebar( 'content-bottom' ); ?>
</div>

<script>
    ;(function () {
        var highcharts = document.getElementById('highcharts')
        var keys = Object.keys(allData).reverse()

        for(var i = 0; i < keys.length; i++) {
            var key = keys[i]

            var child = document.createElement('div')
            child.id = 'highcharts-' + key
            highcharts.appendChild(child)

            genarateGraph(key, allData[key])
        }
    })()

    function getAllMonths () {
        var month = []
        for(var i = 1; i <= 12; i++) {
            month.push(('0' + i).slice(-2))
        }
        return month
    }

    function getGapDay (arr, year) {
        var gapArr = []
        for(var i = 0; i < arr.length; i++) {
            if (arr[i] === null) {
                gapArr.push(null)
                continue
            }
            if (i === 0) {
                var lastYear = year - 1

                if (!allData.hasOwnProperty(lastYear)) { // 没有往年数据的情况
                    gapArr.push(null)                    
                    continue
                }
                var lastYear12 = new Date(lastYear, 12, 0).getDate()
                var lastYear11 = new Date(lastYear, 11, 0).getDate()

                var add = arr[i]
                if (allData[lastYear][11] === null) {
                    add = add + lastYear12 + (llastMonthDate - allData[lastYear][10])
                } else {
                    add = add + (lastYear12 - allData[lastYear][11])
                }
            } else {
                var lastMonthDate = new Date(year, i, 0).getDate() // 第 i 月份天数
                var llastMonthDate = new Date(year, i - 1, 0).getDate()

                var add = arr[i]
                if (arr[i - 1] === null) {
                    add = add + lastMonthDate + (llastMonthDate - arr[i - 2])
                } else {
                    add = add + (lastMonthDate - arr[i - 1])
                }
            }

            gapArr.push(add);
        }

        return gapArr
    }

    function genarateGraph(year, series) {
        Highcharts.chart('highcharts-' + year, {
            title: {
                text: 'My ' + year + ' menstruation records.'
            },
            yAxis: {
                title: {
                    text: 'Days'
                }
            },
            xAxis: {
                title: {
                    text: 'Month of Year'
                },
                categories: getAllMonths()
            },
            tooltip: {
                formatter: function () {
                    return 'The <b>' + this.series.name + '</b> in <b>' + this.x + '</b> month is <b>' + ('0' + this.y).slice(-2) + '</b>.';
                }
            },
            series: [
                {
                    type: 'scatter',
                    name: 'Menstruation Day',
                    data: series
                },
                {
                    type: 'line',
                    name: 'Gap Day',
                    data: getGapDay(series, year)
                }
            ],
        });
    }
</script>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
