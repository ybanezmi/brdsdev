<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <title><?= $this->title ?></title>
    <link rel="shortcut icon" href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/images/favicon.ico" type="image/x-icon">
    <?php $this->head() ?>
    <style>
        html {
            font-family: 'Open Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        *
        {
            margin:0;
            padding:0;
            color:#000;
        }
        body
        {
            width:100%;
            margin:0;
            padding:0;
        }
         
        hr
        {
            color:#aaa;
            background:#aaa;
        }

        .dispatch, .page-header {
            width: 100%;
            height: 100%;
            padding: 20px 30px;
            font-weight: bold;
            font-size: 12px;
            line-height: 20px;
        }
        .row_1_title{
            position: relative;
            font-size:25px;
            margin-top:20px;
            margin-bottom:5px;
            line-height: 28px;
        }
        .row_2_cnumber{
            position: relative;
            font-size:12px;
            font-weight: normal;
        }
        .row_3_deliver{
            position: relative;
            font-size:12px;
            font-weight: normal;
        }
        .row_4_deliver{
            position: relative;
            font-size:12px;
            font-weight: normal;
            margin-left: 0px;
            margin-top: 10px;
        }
        .row_ship{
            position: relative;
            font-size:12px;
            font-weight: normal;
            margin-left: 6px;
        }
        .row_date{
            position: relative;
            font-size:12px;
            font-weight: normal;
            margin-bottom: 10px;
            margin-left: 6px;
        }
        .row_cond{
            position: relative;
            font-size:12px;
            font-weight: normal;
            margin-left: 6px;
        }
        .row_weight{
            position: relative;
            font-size:12px;
            font-weight: normal;
            margin-left: 6px;
        }
        .ship_info{
            position: relative;
            font-size:12px;
            font-weight: normal;
            margin-left: 6px;
        }
        .item-list{
            width: 100%;
            position: relative;
            font-size:12px;
            font-weight: normal;
        }
        
        .item-list td {
            vertical-align: top;
        }

        .shipping_title{
            background: #ccc;
            width:100%;
            padding-left: 5px;
            line-height: 25px;
        }
        .conditions{
            background: #ccc;
            width:100%;
            padding-left: 5px;
            line-height: 25px;
        }
        .shipping_details{
            background: #ccc;
            width:100%;
            padding-left: 5px;
            line-height: 25px;
        }

        .two_column{
            clear: both;
            overflow: hidden;
            width: 100%;
        }
        .right_column{
            float: right;
            width: 40%;
        }
        .perfect-right_column{
            float: right;
            width: 50%;
        }
        .left_column{
            float: left;
            width: 50%;
        }
        .footer_bar{
            width:100%;
            font-size: 12px;
            line-height: 18px;
            position: fixed;
            bottom: 0;
        }

        .f_info4 {
            font-size: 11px;
            font-style: italic;
            width: 40%;
            text-align: center;
        }   

         
      
        div.breakNow {
            page-break-inside:avoid; 
            page-break-after:always;            
        }

        div.dispatch-table{
            height: 90mm;
        }

        @page {
            /* ensure you append the header/footer name with 'html_' */
            header: html_DispatchHeader; /* sets <htmlpageheader name="MyCustomHeader"> as the header */
            footer: html_DispatchFooter; /* sets <htmlpagefooter name="MyCustomFooter"> as the footer */
            size: auto;
            margin-top: 540px;
            margin-bottom: 50px;
        }

        /* first PDF page */
        @page :last {
            footer: html_signature;
            size: auto;
        }

        /* odd / left PDF page */
        @page :left {
         
        }

        /* even / right PDF page */
        @page :right {
          
        }
    </style>
</head>
<body>
    <?= $content ?>
</body>
</html>
