<?php
?>
  <div class="page-group">
<script>
$(document).on("pageInit", function() {
    var loading = false;
    var itemsPerLoad = 20;
    var maxItems = 200;
    var lastIndex = $('.list-container li')[0].length;

    function addItems(ajaxData) {
        // 生成新条目的HTML
        var html = '';
        var dataLen = ajaxData.length;
        for (var i  = 0 ; i < dataLen ; i++) {
            html += '<li class="list-li"><div class="train-container"><div class="train-station"><span class="train-station-name">'+ajaxData[i].startData.from+'</span><span class="train-time">'+ajaxData[i].startData.startTime+'</span></div><div class="train-line"><span class="train-range">8小时</span><i class="icon-train"></i><span class="train-no">'+ajaxData[i].startData.trainno+'</span></div><div class="train-middle"><span class="train-station-name">'+ajaxData[i].middleData.from+'</span><span class="train-time">'+ajaxData[i].startData.endTime+'|'+ajaxData[i].middleData.startTime+'</span></div><div class="train-line"><span class="train-range">36分</span><i class="icon-train"></i><span class="train-no">'+ajaxData[i].middleData.trainno+'</span></div><div class="train-station"><span class="train-station-name">'+ajaxData[i].middleData.to+'</span><span class="train-time">'+ajaxData[i].middleData.endTime+'</span></div></div></li>';
        }
        // 添加新条目
        $('.infinite-scroll.active .list-container').append(html);
    }
    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }

    $(document).on('infinite', function() {
        // 如果正在加载，则退出
        if (loading)
            return;
        // 设置flag
        loading = true;
        var tabIndex = 0;
        if ($(this).find('.infinite-scroll.active').attr('id') == "tab1") {
            tabIndex = 0;
        }else if ($(this).find('.infinite-scroll.active').attr('id') == "tab2") {
            tabIndex = 1;
        }else if ($(this).find('.infinite-scroll.active').attr('id') == "tab3") {
            tabIndex = 2;
        }else if ($(this).find('.infinite-scroll.active').attr('id') == "tab4") {
            tabIndex = 3;
        }
        console.log($(this).find('.infinite-scroll.active.active').attr('id'));
        console.log(tabIndex);
        lastIndex = $('.list-container').eq(tabIndex).find('li').length;
        console.log(lastIndex);
        loading = false;
        if (lastIndex >= maxItems) {
            $('.infinite-scroll-preloader').eq(tabIndex).hide();
            return;
        }
        $.ajax({
            type:'GET',
            url: '/touch/index.php/index/searchapi',
            data: {
                s:getParameterByName('s'),
                d:getParameterByName('d'),
                page:lastIndex/20,
                counts:20,
                type:tabIndex+1
            },
            dataType: 'json',
            timeout: 300,
            context: $('body'),
            success: function(data){
                //this.append(data.project.html)
                addItems(data[tabIndex+1]);
                lastIndex = $('.list-container').eq(tabIndex).find('li').length;
                $.refreshScroller();
                console.log(data[tabIndex+1]);
            },
            error: function(xhr, type){
                alert('Ajax error!')
            }
        });
    });
});
$.init();
</script>
      <!-- 你的html代码 -->
      <div class="page">
          <header class="bar bar-nav">
              <a class="button button-link button-nav pull-left back">
              <span class="icon icon-left"></span>
                返回
              </a>
              <h1 class="title">搜索结果</h1>
          </header>
          <nav class="bar bar-tab">
              <a class="tab-item external active" href="#">
                  <span class="icon icon-home"></span>
                  <span class="tab-label">首页</span>
              </a>
              <a class="tab-item external" href="#">
                  <span class="icon icon-star"></span>
                  <span class="tab-label">收藏</span>
              </a>
                <a class="tab-item external" href="#">
                  <span class="icon icon-me"></span>
                  <span class="tab-label">我</span>
              </a>
          </nav>
          <div class="content">
              <!-- 这里是页面内容区 -->
                <div class="content">
                  <div class="buttons-tab">
                    <a href="#tab1" class="tab-link active button">默认</a>
                    <a href="#tab2" class="tab-link button">总时间</a>
                    <a href="#tab3" class="tab-link button">乘车时间</a>
                    <a href="#tab4" class="tab-link button">换乘时间</a>
                  </div>
                 
                    <div class="tabs">
                    <?php
                    foreach($pageContent as $num=>$con){
                        if($num == 1){
                            echo '
                                <div id="tab'.$num.'" class="tab active infinite-scroll">
                                <div class="list-block media-list" style="margin: 0.5rem 0;">
                                <ul class="list-container">
                                ';
                        }else{
                            echo '
                                <div id="tab'.$num.'" class="tab infinite-scroll">
                                <div class="list-block media-list" style="margin: 0.5rem 0;">
                                <ul class="list-container">
                                ';
                        }
                        foreach($con as $c){
                        $startRange = strpos($c['startData']['duration'] , '小时') ? substr($c['startData']['duration'] , 0 , strpos($c['startData']['duration'] , '小时')).'小时':$c['startData']['duration'];
                        $middleRange = strpos($c['middleData']['duration'] , '小时') ? substr($c['middleData']['duration'] , 0 , strpos($c['middleData']['duration'] , '小时')).'小时':$c['middleData']['duration'];

                        echo '
                               <li class="list-li">
                                  <div class="train-container"> 
                                    <div class="train-station">
                                     <span class="train-station-name">'.$c['startData']['from'].'</span>
                                     <span class="train-time">'.$c['startData']['startTime'].'</span>
                                    </div>
                                    <div class="train-line">
                                    <span class="train-range">'.$startRange.'</span>
                                      <i class="icon-train"> &#xe601; </i>
                                      <span class="train-no">'.$c['startData']['trainno'].'</span>
                                    </div>                                    
                                    <div class="train-middle">
                                      <span class="train-station-name">'.$c['startData']['to'].'</span>
                                      <span class="train-time">'.$c['startData']['endTime'].' | '.$c['middleData']['startTime'].'</span>
                                    </div>
                                    <div class="train-line">
                                      <span class="train-range">'.$middleRange.'</span>
                                      <i class="icon-train"> &#xe601; </i>
                                      <span class="train-no">'.$c['middleData']['trainno'].'</span>
                                    </div> 
                                      <div class="train-station">
                                      <span class="train-station-name">'.$c['middleData']['to'].'</span>
                                     <span class="train-time">'.$c['middleData']['endTime'].'</span>
                                    </div>  
                                  </div>
                              </li>';
                        }
                        echo '
                            </ul>
                          </div>
                      </div>';
                    }
                    ?>
                      
                    </div>
                 
                </div>
          </div>
      </div>
  </div>

    <script type='text/javascript' src='//g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'>
</script>
    <script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/sm.min.js' charset='utf-8'>
</script>
    <script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/sm-extend.min.js' charset='utf-8'>
</script>
