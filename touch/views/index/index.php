<?php
?>
  <div class="page-group">
      <!-- 你的html代码 -->
      <div class="page">
          <header class="bar bar-nav">
              <h1 class="title">出行-touch</h1>
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
                <div class="list-block">
                    <ul>
                      <!-- Text inputs -->
                      <li>
                        <div class="item-content">
                          <div class="item-media"><i class="icon icon-form-name"></i></div>
                          <div class="item-inner">
                            <div class="item-title label">出发地</div>
                            <div class="item-input">
                              <input type="text" id="city-source" placeholder="出发地">
                            </div>
                          </div>
                        </div>
                      </li>
                         
                      <li>
                        <div class="item-content">
                          <div class="item-media"><i class="icon icon-form-name"></i></div>
                          <div class="item-inner">
                            <div class="item-title label">目的地</div>
                            <div class="item-input">
                              <input type="text" id="city-dest" placeholder="目的地">
                            </div>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                  <div class="content-block">
                    <div class="row">
                      <div class="col-100" ><a id="submit-search"  href="#" class="button button-big button-fill button-success">提交</a></div>
                    </div>
                  </div>
          </div>
      </div>
  </div>
    <script type='text/javascript' src='//g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/sm.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/sm-extend.min.js' charset='utf-8'></script>
    <script>
        $.init();
    </script>
    <script>
$(function () {
    'use strict'
  $(document).on("pageInit", function(e, pageId, $page) {
      $('#submit-search').attr('href' , '#');
      $('#submit-search').on('click' , function(e){
            var source = $('#city-source').val();
            var dest = $('#city-dest').val();
            if(source && dest && (dest != source)){
                var url = '/touch/index.php/index/search?'+'s='+source+'&d='+dest;
                $('#submit-search').attr('href' , url);
            }
      })
    $("#city-source").picker({
      toolbarTemplate: '<header class="bar bar-nav">\
      <button class="button button-link pull-left"></button>\
      <button class="button button-link pull-right close-picker">确定</button>\
      <h1 class="title">选择城市</h1>\
      </header>',
      cols: [
        {
          textAlign: 'center',
          values:  [
                     "北京",
                     "上海",
                     "天津",
                     "西安",
                     "深圳",
                     "重庆",
                     "武汉",
                     "广州",
                     "成都",
                     "杭州",
                     "济南",
                     "南京",
                     "郑州",
                     "长春",
                     "哈尔滨",
                     "长沙",
                     "大连",
                     "沈阳",
                     "青岛",
                     "石家庄",
                     "南昌",
                     "合肥",
                     "福州",
                     "太原",
                     "兰州",
                    ],
            }
        ]
        });
        $("#city-dest").picker({
              toolbarTemplate: '<header class="bar bar-nav">\
              <button class="button button-link pull-left"></button>\
              <button class="button button-link pull-right close-picker">确定</button>\
              <h1 class="title">选择城市</h1>\
              </header>',
              cols: [
                {
                  textAlign: 'center',
                  values:  [
                             "北京",
                             "上海",
                             "天津",
                             "西安",
                             "深圳",
                             "重庆",
                             "武汉",
                             "广州",
                             "成都",
                             "杭州",
                             "济南",
                             "南京",
                             "郑州",
                             "长春",
                             "哈尔滨",
                             "长沙",
                             "大连",
                             "沈阳",
                             "青岛",
                             "石家庄",
                             "南昌",
                             "合肥",
                             "福州",
                             "太原",
                             "兰州",
                            ],
                    }
                ]
                });
            });
            $.init();
        });
    </script>
