<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//cdn.bootcss.com/normalize/6.0.0/normalize.css" rel="stylesheet">
    <link href="//cdn.bootcss.com/material-design-lite/1.3.0/material.min.css" rel="stylesheet">
    <link href="//cdn.bootcss.com/material-design-icons/3.0.1/iconfont/material-icons.min.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="//cdn.bootcss.com/dialog-polyfill/0.4.7/dialog-polyfill.min.css" rel="stylesheet">
    <title></title>
    <style>
        html, body {
            padding: 0;
            margin: 0;
        }
    </style>
</head>
<body>
<!-- Uses a transparent header that draws on top of the layout's background -->
<style>
    .demo-layout-transparent {
        background: url('https://getmdl.io/assets/demos/transparent.jpg') center / cover;
    }

    .demo-layout-transparent .mdl-layout__header,
    .demo-layout-transparent .mdl-layout__drawer-button {
        /* This background is dark, so we set text to white. Use 87% black instead if
           your background is light. */
        color: white;
    }
    .fileList{
        cursor: pointer;
    }
    .fileList:hover{
        background: rgba(0,0,0,0.2);
    }
</style>

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
            <span class="mdl-layout-title"><?=basename($path) ?></span>
        </div>
    </header>
    <div class="mdl-layout__drawer">
        <span class="mdl-layout-title">Title</span>
        <nav class="mdl-navigation">
            <a class="mdl-navigation__link" href="">Link</a>
            <a class="mdl-navigation__link" href="">Link</a>
            <a class="mdl-navigation__link" href="">Link</a>
            <a class="mdl-navigation__link" href="">Link</a>
        </nav>
    </div>
    <main class="mdl-layout__content">
        <ul class="mdl-list">
            <?php foreach ($Dirs as $dir): ?>
                <li class="mdl-list__item mdl-list__item--two-line">
                    <span class="mdl-list__item-primary-content">
                        <i class="fa fa-folder-o mdl-list__item-icon" style="font-size: 24px;"></i>
                        <span>
                            <a href="/index.php?Files/List<?= $dir['path'] ?>" style="color: rgba(0,0,0,.87);text-decoration: none;"><?= $dir['name'] ?></a></span>
                        <span class="mdl-list__item-sub-title">dir</span>
                    </span>
                    <span class="mdl-list__item-secondary-content">
                        <span class="mdl-list__item-secondary-info">
                            <?=lastChange($dir['path'])?>
                        </span>
                    </span>

                </li>
            <?php endforeach; ?>
            <?php foreach ($Files as $file): ?>
                <li class="mdl-list__item mdl-list__item--two-line fileList" data-path="<?= $file['path'] ?>" data-name="<?= $file['name'] ?>">

                    <span class="mdl-list__item-primary-content">
                        <i class="<?=fileIcon($file['path'])?> mdl-list__item-icon" style="font-size: 24px;" aria-hidden="true"></i>
                        <span>
                            <?= $file['name'] ?>
                        </span>
                        <span class="mdl-list__item-sub-title"><?=size($file['path'])?></span>

                    </span>
                    <span class="mdl-list__item-secondary-content">
                        <span class="mdl-list__item-secondary-info">
                            <?=lastChange($file['path'])?>
                        </span>
                    </span>
                </li>
            <?php endforeach; ?>

        </ul>


    </main>
</div>
<dialog class="mdl-dialog">
    <h4 class="mdl-dialog__title">信息</h4>
    <div class="mdl-dialog__content">
        <p>
            文件名：
        </p>
    </div>
    <div class="mdl-dialog__actions">
        <button type="button" class="mdl-button close">Close</button>
    </div>
</dialog>
<script src="//cdn.bootcss.com/material-design-lite/1.3.0/material.min.js"></script>
<script src="//cdn.bootcss.com/jquery/3.2.1/jquery.slim.min.js"></script>
<script src="//cdn.bootcss.com/dialog-polyfill/0.4.7/dialog-polyfill.min.js"></script>
<script>
    $( document ).ready(function (){
        $('.fileList').on('click',function () {
            var dialog = document.querySelector('dialog');
            jQuery(dialog).find('p').html('文件名：'+$(this).data('name')+'<br>路径：'+$(this).data('path'));
            dialogPolyfill.registerDialog(dialog);
            // Now dialog acts like a native <dialog>.
            dialog.showModal();
            jQuery(dialog).find('.close').on('click',function () {
                dialog.close();
            })
        });
        console.log('Start');
        $('#fileFilter').on('change',function () {
            filter = $(this).val();
            console.log('过滤内容：'+filter);
        });
    });
</script>
<!--<ul>-->
<!--    <li>-->
<!--        当前路径:--><? //= $path ?><!--<a href="/index.php?Files/List--><? //= dirname($path) ?><!--">返回上级</a>-->
<!--    </li>-->
<!---->
<!--</ul>-->


</body>
</html>
<?php

