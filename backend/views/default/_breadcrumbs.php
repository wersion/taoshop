<div class="breadcrumbs" id="breadcrumbs">
            <script type="text/javascript">
                    try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
            </script>

<?= \yii\widgets\Breadcrumbs::widget([
        'itemTemplate' => '<li><i class="icon-home home-icon"></i>{link}</li>',
        'links' => isset($this->params['breadcrumbs'])? $this->params['breadcrumbs'] : [],
        ])?>

            <!-- #section:basics/content.searchbox -->
            <div class="nav-search" id="nav-search">
                    <form class="form-search">
                            <span class="input-icon">
                                    <input type="text" placeholder="开始搜索" class="nav-search-input" id="nav-search-input" autocomplete="off" />
                                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                            </span>
                    </form>
            </div><!-- /.nav-search -->

            <!-- /section:basics/content.searchbox -->
    </div>