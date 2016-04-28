<?php
?>
  <div class="page-group">
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
                                <div id="tab'.$num.'" class="tab active">
                                <div class="list-block media-list" style="margin: 0.5rem 0;">
                                <ul>
                                ';
                        }else{
                            echo '
                                <div id="tab'.$num.'" class="tab">
                                <div class="list-block media-list" style="margin: 0.5rem 0;">
                                <ul>
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
    <script>
    $.init();
   </script>
