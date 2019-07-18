<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::$app->name;
if (class_exists('\yii\debug\Module')) {
    Yii::$app->view->off(\yii\web\View::EVENT_END_BODY, [
        \yii\debug\Module::getInstance(),
        'renderToolbar'
    ]);
}
?>
<div id="wrapper">
    <!--左侧导航开始-->
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="nav-close"><i class="fa fa-times-circle"></i>
        </div>
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li class="nav-header">
                    <div class="profile-element dropdown">
                        <span class="logo">
                            <img alt="image" src="<?php echo Url::to('@web/img/logo_with_title.png'); ?>"/>
                            <span class="logo-title">如来云wifi</span>
                        </span>
                    </div>
                    <div class="logo-element">
                        <img alt="image" src="<?php echo Url::to('@web/img/logo_with_title.png'); ?>"/>
                    </div>
                </li>

                <?php foreach ($menu as $v1): ?>
                    <?php $data = json_decode($v1['data'], true); ?>
                    <li><!--一级级菜单-->
                        <a href="<?= isset($v1['_child']) ? '#' : Url::toRoute([$v1['route']]) ?>"
                           class="<?= isset($v1['_child']) ? '' : 'J_menuItem' ?>">
                            <i class="<?= $data['icon'] ?>"></i>
                            <span class="nav-label"><?= $v1['name'] ?></span>
                            <?= isset($v1['_child']) ? '<span class="fa arrow"></span>' : '' ?>
                        </a>

                        <?php if (array_key_exists('_child', $v1)): ?>

                            <ul class="nav nav-second-level">
                                <?php foreach ($v1['_child'] as $v2): ?>
                                    <?php $data2 = json_decode($v2['data'], true); ?>

                                    <?php if (array_key_exists('_child', $v2)): ?>
                                        <li><!--二级菜单-->

                                            <a href="#">
                                                <?php if ($data2['icon']): ?><i
                                                    class="<?= $data2['icon'] ?>"></i><?php endif; ?><?= $v2['name'] ?>
                                                <span class="fa arrow"></span>
                                            </a>
                                            <?php if (!empty($v2['_child'])): ?>
                                                <ul class="nav nav-third-level collapse">
                                                    <?php foreach ($v2['_child'] as $v3): ?>
                                                        <li><!--三级菜单-->
                                                            <?php $data3 = json_decode($v3['data'], true); ?>
                                                            <a class="J_menuItem"
                                                               href="<?= Url::toRoute($v3['route']) ?>"
                                                               data-index="0"><?= $v3['name'] ?></a>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php endif; ?>
                                        </li>
                                    <?php else: ?>
                                        <li><!--二级菜单-->
                                            <?php if (array_keys($data2)[0] == 'type'): ?>
                                                <a class="J_menuItem"
                                                   href="<?= Url::toRoute(array_merge([$v2['route']], $data2)); ?>"
                                                   data-index="0"><?= $v2['name'] ?></a>
                                            <?php else: ?>
                                                <a class="J_menuItem" href="<?= Url::toRoute($v2['route']); ?>"
                                                   data-index="0"><?= $v2['name'] ?></a>
                                            <?php endif; ?>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                    </li>
                <?php endforeach; ?>

            </ul>
        </div>
    </nav>
    <!--左侧导航结束-->
    <!--右侧部分开始-->
    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <a class="navbar-minimalize" href="#" style="color: #797979;">
                    <i class="fa fa-bars"></i>
                </a>
                <ul class="nav navbar-top-links" style="height: 50px;line-height: 50px;">
                    <li class="dropdown hidden-xs admin-info">
                        <span>
                            登录用户：<?= Yii::$app->user->identity->nick_name ?>
                        </span>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="row content-tabs">
            <button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i>
            </button>
            <nav class="page-tabs J_menuTabs">
                <div class="page-tabs-content">
                    <a href="javascript:;" class="active J_menuTab" data-id="index_v1.html">首页</a>
                </div>
            </nav>
            <button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i>
            </button>
            <div class="btn-group roll-nav roll-right">
                <button class="dropdown J_tabClose" data-toggle="dropdown">关闭操作<span class="caret"></span>

                </button>
                <ul role="menu" class="dropdown-menu dropdown-menu-right">
                    <li class="J_tabShowActive"><a>定位当前选项卡</a>
                    </li>
                    <li class="divider"></li>
                    <li class="J_tabCloseAll"><a>关闭全部选项卡</a>
                    </li>
                    <li class="J_tabCloseOther"><a>关闭其他选项卡</a>
                    </li>
                </ul>
            </div>
            <!--            <a href="-->
            <? //=Url::toRoute('site/logout')?><!--" class="roll-nav roll-right J_tabExit"><i class="fa fa fa-sign-out"></i> 退出</a>-->
            <a data-url=<?= Url::toRoute('site/logout') ?> class="roll-nav roll-right J_tabExit login-out"><i
                    class="fa fa fa-sign-out"></i> 退出</a>
        </div>
        <div class="row J_mainContent" id="content-main">
            <iframe class="J_iframe" name="iframe0" width="100%" height="100%"
                    src="<?= Url::toRoute('index/welcome') ?>" frameborder="0" data-id="index_v1.html"
                    seamless></iframe>
        </div>
        <div class="footer footer-index">
            <div>
                版本号:<span>v1.0.1</span>
            </div>
        </div>
    </div>
    <!--右侧部分结束-->
    <!--右侧边栏开始-->
    <div id="right-sidebar" class="gray-bg dashbard-1">
        <div class="border-bottom row">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <a class="navbar-minimalize" href="#tab-1">
                    <i class="fa fa-bars"></i>
                </a>
            </nav>
        </div>
        <div class="sidebar-container">


            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="sidebar-title">
                        <h3><i class="fa fa-comments-o"></i> 主题设置</h3>
                        <small><i class="fa fa-tim"></i> 你可以从这里选择和预览主题的布局和样式，这些设置会被保存在本地，下次打开的时候会直接应用这些设置。</small>
                    </div>
                    <div class="skin-setttings">
                        <div class="title">主题设置</div>
                        <div class="setings-item">
                            <span>收起左侧菜单</span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox"
                                           id="collapsemenu">
                                    <label class="onoffswitch-label" for="collapsemenu">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                            <span>固定顶部</span>

                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="fixednavbar" class="onoffswitch-checkbox"
                                           id="fixednavbar">
                                    <label class="onoffswitch-label" for="fixednavbar">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                            <span>
                                固定宽度
                            </span>

                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="boxedlayout" class="onoffswitch-checkbox"
                                           id="boxedlayout">
                                    <label class="onoffswitch-label" for="boxedlayout">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="title">皮肤选择</div>
                        <div class="setings-item default-skin nb">
                                <span class="skin-name ">
                         <a href="#" class="s-skin-0">
                             默认皮肤
                         </a>
                    </span>
                        </div>
                        <div class="setings-item blue-skin nb">
                                <span class="skin-name ">
                        <a href="#" class="s-skin-1">
                            蓝色主题
                        </a>
                    </span>
                        </div>
                        <div class="setings-item yellow-skin nb">
                            <span class="skin-name ">
                                <a href="#" class="s-skin-3">
                                    黄色/紫色主题
                                </a>
                            </span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <!--右侧边栏结束-->

</div>

<?php
    $css = <<<CSS
    /*------logo块------*/
    .logo img{
        width: 34px;
        vertical-align: middle;
        margin-right: 2px;
    }
    .logo-title{
       font-size:16px;
       color: #fff;
       display: inline-block;
       vertical-align: -4px;
    }
    .nav-header{
        padding-left: 19px;
    }
    
    /*-----顶部用户信息切换模式按钮块-----*/
    .navbar-static-top{
        text-align: right;
        background: #fff;
    }
    #userInfo{
        display: inline-block;
    }
    .navbar-minimalize{
        font-size: 20px;
        position: absolute;
        left: 40px;
        height: 50px;
        line-height: 50px;
    }
    /*-----后台登录后首页页脚-----*/
    .footer-index{
        background: #5b6e84;
        border-top: 1px solid #e7eaec;
        padding: 10px 20px;
        height: 40px;
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        text-align: center;
        color: #fff;
        text-align: right;
        font-weight: 600;
        padding-right: 40px;
        box-sizing: border-box;
    }
    .logo-element img{
        width: 30px;
        height: auto;
    }
    .admin-info span{
        margin-right: 10px;
        font-weight: 600;
        color: #6C6C6C;
    }
CSS;
    $this->registerCss($css);
?>
<?php
    $js = <<<JS
    $(".login-out").on("click",function() {
        var that = this;
        layer.confirm('确认退出登录吗？', {
          btn: ['确定', '取消'] 
        }
        ,function(index, layero){
            // 确定回调
            window.location.href = $(that).attr('data-url');
          }
        ,function(index, layero){
          // 取消回调 TODO...
          
        });
    })
    var index="1";
JS;
    $this->registerJs($js);
?>
<?= Html::jsFile('@web/js/plugins/metisMenu/jquery.metisMenu.js') ?>
<?= Html::jsFile('@web/js/plugins/slimscroll/jquery.slimscroll.min.js') ?>
<?= Html::jsFile('@web/js/hplus.min.js') ?>
<?= Html::jsFile('@web/js/contabs.min.js') ?>
<?= Html::jsFile('@web/js/plugins/pace/pace.min.js') ?>

