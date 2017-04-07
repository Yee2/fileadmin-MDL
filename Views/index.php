<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//cdn.bootcss.com/normalize/6.0.0/normalize.css" rel="stylesheet">
    <link href="//cdn.bootcss.com/material-design-lite/1.3.0/material.min.css" rel="stylesheet">
    <link href="//cdn.bootcss.com/material-design-icons/3.0.1/iconfont/material-icons.min.css" rel="stylesheet">
    <link href="//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="//cdn.bootcss.com/dialog-polyfill/0.4.7/dialog-polyfill.min.css" rel="stylesheet">
    <title></title>
    <style>
        html, body {
            padding: 0;
            margin: 0;
        }
        .demo-layout-transparent {
            background: url('https://getmdl.io/assets/demos/transparent.jpg') center / cover;
        }

        .demo-layout-transparent .mdl-layout__header,
        .demo-layout-transparent .mdl-layout__drawer-button {
            /* This background is dark, so we set text to white. Use 87% black instead if
               your background is light. */
            color: white;
        }

        .file-list li{
            cursor: pointer;
        }

        .file-list li:hover {
            background: rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
<!-- Uses a transparent header that draws on top of the layout's background -->


<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <header class="mdl-layout__header mdl-layout__header--waterfall">
        <div class="mdl-layout__header-row ">
            <!-- Title -->
            <span class="mdl-layout-title">My Files</span>
            <!-- Add spacer, to align navigation to the right -->
            <div class="mdl-layout-spacer"></div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable
                  mdl-textfield--floating-label mdl-textfield--align-right">
                <label class="mdl-button mdl-js-button mdl-button--icon"
                       for="fixed-header-drawer-exp">
                    <i class="material-icons">search</i>
                </label>
                <div class="mdl-textfield__expandable-holder">
                    <input class="mdl-textfield__input" type="text" name="sample"
                           id="fileFilter">
                </div>
            </div>
        </div>
        <div class="mdl-layout__header-row">
            <span class="mdl-layout-title" id="DirName"></span>
        </div>
    </header>
    <div class="mdl-layout__drawer">
        <span class="mdl-layout-title">Title</span>
        <nav class="mdl-navigation" id="Favorites">
        </nav>
    </div>
    <main class="mdl-layout__content">
        <ul class="mdl-list file-list" id="files"></ul>
    </main>
</div>

<dialog class="mdl-dialog" id="fileInfo">
    <h4 class="mdl-dialog__title">信息</h4>
    <div class="mdl-dialog__content">
        <p>
            文件名：
        </p>
    </div>
    <div class="mdl-dialog__actions">
        <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored close">Close</button>
    </div>
</dialog>
<template id="template-dir">
    <li class="mdl-list__item mdl-list__item--two-line">
        <span class="mdl-list__item-primary-content dirs" data-path="{#path}">
            <i class="fa fa-folder-o mdl-list__item-icon" style="font-size: 24px;"></i>
            <span>{#name}</span>
            <span class="mdl-list__item-sub-title">dir</span>
        </span>
        <span class="mdl-list__item-secondary-content">
        <button class="mdl-button mdl-js-button mdl-button--icon mdl-list__item-secondary-action dirMenu" data-path="{#path}">
            <i class="material-icons">more_vert</i>
        </button>
        </span>

    </li>
</template>
<template id="template-back">
    <li class="mdl-list__item">
        <span class="mdl-list__item-primary-content dirs" data-path="{#path}">
            <i class="fa fa-arrow-circle-o-left mdl-list__item-icon" style="font-size: 24px;"></i>
            <span>返回上级</span>
        </span>
        <span class="mdl-list__item-secondary-content">
        </span>

    </li>
</template>
<template id="template-favorite">
    <a class="mdl-navigation__link favorite" data-path="{#path}">{#name}</a>
</template>
<template id="template-file">
    <li class="mdl-list__item mdl-list__item--two-line files" data-path="{#path}" data-name="{#name}">
                    <span class="mdl-list__item-primary-content">
                        <i class="{#icon} mdl-list__item-icon" style="font-size: 24px;"
                           aria-hidden="true"></i>
                        <span>{#name}</span>
                        <span class="mdl-list__item-sub-title">{#size}</span>
                    </span>
        <span class="mdl-list__item-secondary-content">
                  <span class="mdl-list__item-secondary-info">{#date}</span>
        </span>
    </li>
</template>
<dialog class="mdl-dialog" id="dirMenu">
    <h4 class="mdl-dialog__title">操作</h4>
    <div class="mdl-dialog__content">
        <button class="mdl-button mdl-js-button mdl-js-ripple-effect" data-action="delete">
            删除
        </button>
        <button class="mdl-button mdl-js-button mdl-js-ripple-effect" data-action="rename">
            重命名
        </button>
        <button class="mdl-button mdl-js-button mdl-js-ripple-effect" data-action="like">
            收藏
        </button>
    </div>
    <div class="mdl-dialog__actions">
        <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored close">Close</button>
    </div>
</dialog>
<script src="//cdn.bootcss.com/material-design-lite/1.3.0/material.min.js"></script>
<script src="//cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script src="//cdn.bootcss.com/dialog-polyfill/0.4.7/dialog-polyfill.min.js"></script>
<script>
    $(document).ready(function () {
        console.log('Start');
        $('#fileFilter').on('change', function () {
            filter = $(this).val();
            console.log('过滤内容：' + filter);
        });
        init();
    });
    var init = function () {
        function load() {
//            $('.mdl-layout__drawer').toggleClass('is-visible');//关闭抽屉
            var path = $(this).data('path');
            $.ajax({
                dataType: "json",
                url: '/index.php?Files/List' + path,
                data: {},
                success: function (Res) {
                    document.querySelector('#DirName').innerHTML = Res.name;
                    $('#files').empty();
                    render_back(Res.path);
                    render_favorite(Res.Favorites);
                    render_dir(Res.Dirs);
                    render_file(Res.Files);
                }
            });
        }
        function render_back(path) {
            document.getElementById("files").insertAdjacentHTML('beforeend',document.getElementById('template-back').innerHTML.replace('{#path}',path.replace(/\\/g, '/')
                .replace(/\/[^/]*\/?$/, '')));
        }
        function render_file(files) {
            var parent = document.getElementById("files");
            for (var i in files) {
                var temp = document.getElementById('template-file').innerHTML;
                for (var key in files[i]) {
                    temp = temp.replace(new RegExp('{#' + key + '}', 'gm'), files[i][key]);
                }
                parent.insertAdjacentHTML('beforeend', temp);
            }

            $('.files').on('click', function () {
                var dialog = document.querySelector('#fileInfo');
                jQuery(dialog).find('p').html('文件名：' + $(this).data('name') + '<br>路径：' + $(this).data('path'));
                dialogPolyfill.registerDialog(dialog);
                // Now dialog acts like a native <dialog>.
                dialog.showModal();
                jQuery(dialog).find('.close').on('click', function () {
                    dialog.close();
                })
            });
        }

        function render_dir(dirs) {
            var parent = document.getElementById("files");
            for (var i in dirs) {
                var temp = document.getElementById('template-dir').innerHTML;
                for (var key in dirs[i]) {
                    temp = temp.replace(new RegExp('{#' + key + '}', 'gm'), dirs[i][key]);
                }
                parent.insertAdjacentHTML('beforeend', temp);
            }
            $('.dirs').on('click',load);
            $('.dirMenu').on('click',dirMenu);
        }
        function render_favorite(favorites) {
            var parent = document.getElementById("Favorites");
            $(parent).empty();
            for (var i in favorites) {
                var temp = document.getElementById('template-favorite').innerHTML;
                for (var key in favorites[i]) {
                    temp = temp.replace(new RegExp('{#' + key + '}', 'gm'), favorites[i][key]);
                }
                parent.insertAdjacentHTML('beforeend', temp);
            }
            $('.favorite').on('click',function (){
                var layout = document.querySelector('.mdl-layout');
                layout.MaterialLayout.toggleDrawer();
                load.call(this);
            });
        }
        function dirMenu() {
            var path = $(this).data('path');
            var dialog = document.querySelector('#dirMenu');
            jQuery(dialog).find('button').data('path',$(this).data('path'));
            jQuery(dialog).find('button').each(function () {
                if(typeof ($(this).attr('data-action')) == "undefined"){
                    return ;
                }
                $(this).on('click',function () {
                    switch ($(this).data('action')){
                        case 'delete':
                            $('.close').trigger('click');
                            deleteAction.call(this);
                            break ;
                        case 'rename':
                            $('.close').trigger('click');
                            break ;
                        default:
                    }
                });
            });
            dialogPolyfill.registerDialog(dialog);
            // Now dialog acts like a native <dialog>.
            dialog.showModal();
            jQuery(dialog).find('.close').on('click', function () {
                dialog.close();
            })
        }
        function deleteAction() {
            console.log($(this).data('path'));
        }
        load.call($('<div data-path="/.."></div>'));
    }
</script>
</body>
</html>
