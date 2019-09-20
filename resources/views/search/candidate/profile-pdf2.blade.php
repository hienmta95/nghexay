<!doctype html>
<html>
<head>
    <meta name="viewport" content="width=device-width"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <title>Hồ sơ {!! $candidate->name !!}</title>
    <style>
        /* -------------------------------------
            GLOBAL RESETS
        ------------------------------------- */
        img {
            border: none;
            -ms-interpolation-mode: bicubic;
            max-width: 100%;
        }

        body {
            background-color: #fff;
            font-family: "DejaVu Sans", sans-serif;
            -webkit-font-smoothing: antialiased;
            font-size: 14px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        table {
            border-collapse: separate;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
            width: 100%;
        }

        table td {
            font-size: 14px;
            vertical-align: top;
        }

        /* -------------------------------------
            BODY & CONTAINER
        ------------------------------------- */

        .body {
            background-color: #f6f6f6;
            width: 100%;
        }

        /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
        .container {
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
            max-width: 1024px;
        }

        @media (min-width: 768px) {
            .container {
                width: 750px;
            }
        }

        @media (min-width: 992px) {
            .container {
                width: 970px;
            }
        }

        @media (min-width: 1200px) {
            .container {
                width: 1170px;
            }
        }

        .container-fluid {
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }

        .row {
            margin-right: -15px;
            margin-left: -15px;
        }

        .row-no-gutters {
            margin-right: 0;
            margin-left: 0;
        }

        .row-no-gutters [class*="col-"] {
            padding-right: 0;
            padding-left: 0;
        }

        .col-xs-1,
        .col-sm-1,
        .col-md-1,
        .col-lg-1,
        .col-xs-2,
        .col-sm-2,
        .col-md-2,
        .col-lg-2,
        .col-xs-3,
        .col-sm-3,
        .col-md-3,
        .col-lg-3,
        .col-xs-4,
        .col-sm-4,
        .col-md-4,
        .col-lg-4,
        .col-xs-5,
        .col-sm-5,
        .col-md-5,
        .col-lg-5,
        .col-xs-6,
        .col-sm-6,
        .col-md-6,
        .col-lg-6,
        .col-xs-7,
        .col-sm-7,
        .col-md-7,
        .col-lg-7,
        .col-xs-8,
        .col-sm-8,
        .col-md-8,
        .col-lg-8,
        .col-xs-9,
        .col-sm-9,
        .col-md-9,
        .col-lg-9,
        .col-xs-10,
        .col-sm-10,
        .col-md-10,
        .col-lg-10,
        .col-xs-11,
        .col-sm-11,
        .col-md-11,
        .col-lg-11,
        .col-xs-12,
        .col-sm-12,
        .col-md-12,
        .col-lg-12 {
            position: relative;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
        }

        .col-xs-1,
        .col-xs-2,
        .col-xs-3,
        .col-xs-4,
        .col-xs-5,
        .col-xs-6,
        .col-xs-7,
        .col-xs-8,
        .col-xs-9,
        .col-xs-10,
        .col-xs-11,
        .col-xs-12 {
            float: left;
        }

        .col-xs-12 {
            width: 100%;
        }

        .col-xs-11 {
            width: 91.66666667%;
        }

        .col-xs-10 {
            width: 83.33333333%;
        }

        .col-xs-9 {
            width: 75%;
        }

        .col-xs-8 {
            width: 66.66666667%;
        }

        .col-xs-7 {
            width: 58.33333333%;
        }

        .col-xs-6 {
            width: 50%;
        }

        .col-xs-5 {
            width: 41.66666667%;
        }

        .col-xs-4 {
            width: 33.33333333%;
        }

        .col-xs-3 {
            width: 25%;
        }

        .col-xs-2 {
            width: 16.66666667%;
        }

        .col-xs-1 {
            width: 8.33333333%;
        }

        .col-xs-pull-12 {
            right: 100%;
        }

        .col-xs-pull-11 {
            right: 91.66666667%;
        }

        .col-xs-pull-10 {
            right: 83.33333333%;
        }

        .col-xs-pull-9 {
            right: 75%;
        }

        .col-xs-pull-8 {
            right: 66.66666667%;
        }

        .col-xs-pull-7 {
            right: 58.33333333%;
        }

        .col-xs-pull-6 {
            right: 50%;
        }

        .col-xs-pull-5 {
            right: 41.66666667%;
        }

        .col-xs-pull-4 {
            right: 33.33333333%;
        }

        .col-xs-pull-3 {
            right: 25%;
        }

        .col-xs-pull-2 {
            right: 16.66666667%;
        }

        .col-xs-pull-1 {
            right: 8.33333333%;
        }

        .col-xs-pull-0 {
            right: auto;
        }

        .col-xs-push-12 {
            left: 100%;
        }

        .col-xs-push-11 {
            left: 91.66666667%;
        }

        .col-xs-push-10 {
            left: 83.33333333%;
        }

        .col-xs-push-9 {
            left: 75%;
        }

        .col-xs-push-8 {
            left: 66.66666667%;
        }

        .col-xs-push-7 {
            left: 58.33333333%;
        }

        .col-xs-push-6 {
            left: 50%;
        }

        .col-xs-push-5 {
            left: 41.66666667%;
        }

        .col-xs-push-4 {
            left: 33.33333333%;
        }

        .col-xs-push-3 {
            left: 25%;
        }

        .col-xs-push-2 {
            left: 16.66666667%;
        }

        .col-xs-push-1 {
            left: 8.33333333%;
        }

        .col-xs-push-0 {
            left: auto;
        }

        .col-xs-offset-12 {
            margin-left: 100%;
        }

        .col-xs-offset-11 {
            margin-left: 91.66666667%;
        }

        .col-xs-offset-10 {
            margin-left: 83.33333333%;
        }

        .col-xs-offset-9 {
            margin-left: 75%;
        }

        .col-xs-offset-8 {
            margin-left: 66.66666667%;
        }

        .col-xs-offset-7 {
            margin-left: 58.33333333%;
        }

        .col-xs-offset-6 {
            margin-left: 50%;
        }

        .col-xs-offset-5 {
            margin-left: 41.66666667%;
        }

        .col-xs-offset-4 {
            margin-left: 33.33333333%;
        }

        .col-xs-offset-3 {
            margin-left: 25%;
        }

        .col-xs-offset-2 {
            margin-left: 16.66666667%;
        }

        .col-xs-offset-1 {
            margin-left: 8.33333333%;
        }

        .col-xs-offset-0 {
            margin-left: 0%;
        }

        @media (min-width: 768px) {
            .col-sm-1,
            .col-sm-2,
            .col-sm-3,
            .col-sm-4,
            .col-sm-5,
            .col-sm-6,
            .col-sm-7,
            .col-sm-8,
            .col-sm-9,
            .col-sm-10,
            .col-sm-11,
            .col-sm-12 {
                float: left;
            }

            .col-sm-12 {
                width: 100%;
            }

            .col-sm-11 {
                width: 91.66666667%;
            }

            .col-sm-10 {
                width: 83.33333333%;
            }

            .col-sm-9 {
                width: 75%;
            }

            .col-sm-8 {
                width: 66.66666667%;
            }

            .col-sm-7 {
                width: 58.33333333%;
            }

            .col-sm-6 {
                width: 50%;
            }

            .col-sm-5 {
                width: 41.66666667%;
            }

            .col-sm-4 {
                width: 33.33333333%;
            }

            .col-sm-3 {
                width: 25%;
            }

            .col-sm-2 {
                width: 16.66666667%;
            }

            .col-sm-1 {
                width: 8.33333333%;
            }

            .col-sm-pull-12 {
                right: 100%;
            }

            .col-sm-pull-11 {
                right: 91.66666667%;
            }

            .col-sm-pull-10 {
                right: 83.33333333%;
            }

            .col-sm-pull-9 {
                right: 75%;
            }

            .col-sm-pull-8 {
                right: 66.66666667%;
            }

            .col-sm-pull-7 {
                right: 58.33333333%;
            }

            .col-sm-pull-6 {
                right: 50%;
            }

            .col-sm-pull-5 {
                right: 41.66666667%;
            }

            .col-sm-pull-4 {
                right: 33.33333333%;
            }

            .col-sm-pull-3 {
                right: 25%;
            }

            .col-sm-pull-2 {
                right: 16.66666667%;
            }

            .col-sm-pull-1 {
                right: 8.33333333%;
            }

            .col-sm-pull-0 {
                right: auto;
            }

            .col-sm-push-12 {
                left: 100%;
            }

            .col-sm-push-11 {
                left: 91.66666667%;
            }

            .col-sm-push-10 {
                left: 83.33333333%;
            }

            .col-sm-push-9 {
                left: 75%;
            }

            .col-sm-push-8 {
                left: 66.66666667%;
            }

            .col-sm-push-7 {
                left: 58.33333333%;
            }

            .col-sm-push-6 {
                left: 50%;
            }

            .col-sm-push-5 {
                left: 41.66666667%;
            }

            .col-sm-push-4 {
                left: 33.33333333%;
            }

            .col-sm-push-3 {
                left: 25%;
            }

            .col-sm-push-2 {
                left: 16.66666667%;
            }

            .col-sm-push-1 {
                left: 8.33333333%;
            }

            .col-sm-push-0 {
                left: auto;
            }

            .col-sm-offset-12 {
                margin-left: 100%;
            }

            .col-sm-offset-11 {
                margin-left: 91.66666667%;
            }

            .col-sm-offset-10 {
                margin-left: 83.33333333%;
            }

            .col-sm-offset-9 {
                margin-left: 75%;
            }

            .col-sm-offset-8 {
                margin-left: 66.66666667%;
            }

            .col-sm-offset-7 {
                margin-left: 58.33333333%;
            }

            .col-sm-offset-6 {
                margin-left: 50%;
            }

            .col-sm-offset-5 {
                margin-left: 41.66666667%;
            }

            .col-sm-offset-4 {
                margin-left: 33.33333333%;
            }

            .col-sm-offset-3 {
                margin-left: 25%;
            }

            .col-sm-offset-2 {
                margin-left: 16.66666667%;
            }

            .col-sm-offset-1 {
                margin-left: 8.33333333%;
            }

            .col-sm-offset-0 {
                margin-left: 0%;
            }
        }

        @media (min-width: 992px) {
            .col-md-1,
            .col-md-2,
            .col-md-3,
            .col-md-4,
            .col-md-5,
            .col-md-6,
            .col-md-7,
            .col-md-8,
            .col-md-9,
            .col-md-10,
            .col-md-11,
            .col-md-12 {
                float: left;
            }

            .col-md-12 {
                width: 100%;
            }

            .col-md-11 {
                width: 91.66666667%;
            }

            .col-md-10 {
                width: 83.33333333%;
            }

            .col-md-9 {
                width: 75%;
            }

            .col-md-8 {
                width: 66.66666667%;
            }

            .col-md-7 {
                width: 58.33333333%;
            }

            .col-md-6 {
                width: 50%;
            }

            .col-md-5 {
                width: 41.66666667%;
            }

            .col-md-4 {
                width: 33.33333333%;
            }

            .col-md-3 {
                width: 25%;
            }

            .col-md-2 {
                width: 16.66666667%;
            }

            .col-md-1 {
                width: 8.33333333%;
            }

            .col-md-pull-12 {
                right: 100%;
            }

            .col-md-pull-11 {
                right: 91.66666667%;
            }

            .col-md-pull-10 {
                right: 83.33333333%;
            }

            .col-md-pull-9 {
                right: 75%;
            }

            .col-md-pull-8 {
                right: 66.66666667%;
            }

            .col-md-pull-7 {
                right: 58.33333333%;
            }

            .col-md-pull-6 {
                right: 50%;
            }

            .col-md-pull-5 {
                right: 41.66666667%;
            }

            .col-md-pull-4 {
                right: 33.33333333%;
            }

            .col-md-pull-3 {
                right: 25%;
            }

            .col-md-pull-2 {
                right: 16.66666667%;
            }

            .col-md-pull-1 {
                right: 8.33333333%;
            }

            .col-md-pull-0 {
                right: auto;
            }

            .col-md-push-12 {
                left: 100%;
            }

            .col-md-push-11 {
                left: 91.66666667%;
            }

            .col-md-push-10 {
                left: 83.33333333%;
            }

            .col-md-push-9 {
                left: 75%;
            }

            .col-md-push-8 {
                left: 66.66666667%;
            }

            .col-md-push-7 {
                left: 58.33333333%;
            }

            .col-md-push-6 {
                left: 50%;
            }

            .col-md-push-5 {
                left: 41.66666667%;
            }

            .col-md-push-4 {
                left: 33.33333333%;
            }

            .col-md-push-3 {
                left: 25%;
            }

            .col-md-push-2 {
                left: 16.66666667%;
            }

            .col-md-push-1 {
                left: 8.33333333%;
            }

            .col-md-push-0 {
                left: auto;
            }

            .col-md-offset-12 {
                margin-left: 100%;
            }

            .col-md-offset-11 {
                margin-left: 91.66666667%;
            }

            .col-md-offset-10 {
                margin-left: 83.33333333%;
            }

            .col-md-offset-9 {
                margin-left: 75%;
            }

            .col-md-offset-8 {
                margin-left: 66.66666667%;
            }

            .col-md-offset-7 {
                margin-left: 58.33333333%;
            }

            .col-md-offset-6 {
                margin-left: 50%;
            }

            .col-md-offset-5 {
                margin-left: 41.66666667%;
            }

            .col-md-offset-4 {
                margin-left: 33.33333333%;
            }

            .col-md-offset-3 {
                margin-left: 25%;
            }

            .col-md-offset-2 {
                margin-left: 16.66666667%;
            }

            .col-md-offset-1 {
                margin-left: 8.33333333%;
            }

            .col-md-offset-0 {
                margin-left: 0%;
            }
        }

        @media (min-width: 1200px) {
            .col-lg-1,
            .col-lg-2,
            .col-lg-3,
            .col-lg-4,
            .col-lg-5,
            .col-lg-6,
            .col-lg-7,
            .col-lg-8,
            .col-lg-9,
            .col-lg-10,
            .col-lg-11,
            .col-lg-12 {
                float: left;
            }

            .col-lg-12 {
                width: 100%;
            }

            .col-lg-11 {
                width: 91.66666667%;
            }

            .col-lg-10 {
                width: 83.33333333%;
            }

            .col-lg-9 {
                width: 75%;
            }

            .col-lg-8 {
                width: 66.66666667%;
            }

            .col-lg-7 {
                width: 58.33333333%;
            }

            .col-lg-6 {
                width: 50%;
            }

            .col-lg-5 {
                width: 41.66666667%;
            }

            .col-lg-4 {
                width: 33.33333333%;
            }

            .col-lg-3 {
                width: 25%;
            }

            .col-lg-2 {
                width: 16.66666667%;
            }

            .col-lg-1 {
                width: 8.33333333%;
            }

            .col-lg-pull-12 {
                right: 100%;
            }

            .col-lg-pull-11 {
                right: 91.66666667%;
            }

            .col-lg-pull-10 {
                right: 83.33333333%;
            }

            .col-lg-pull-9 {
                right: 75%;
            }

            .col-lg-pull-8 {
                right: 66.66666667%;
            }

            .col-lg-pull-7 {
                right: 58.33333333%;
            }

            .col-lg-pull-6 {
                right: 50%;
            }

            .col-lg-pull-5 {
                right: 41.66666667%;
            }

            .col-lg-pull-4 {
                right: 33.33333333%;
            }

            .col-lg-pull-3 {
                right: 25%;
            }

            .col-lg-pull-2 {
                right: 16.66666667%;
            }

            .col-lg-pull-1 {
                right: 8.33333333%;
            }

            .col-lg-pull-0 {
                right: auto;
            }

            .col-lg-push-12 {
                left: 100%;
            }

            .col-lg-push-11 {
                left: 91.66666667%;
            }

            .col-lg-push-10 {
                left: 83.33333333%;
            }

            .col-lg-push-9 {
                left: 75%;
            }

            .col-lg-push-8 {
                left: 66.66666667%;
            }

            .col-lg-push-7 {
                left: 58.33333333%;
            }

            .col-lg-push-6 {
                left: 50%;
            }

            .col-lg-push-5 {
                left: 41.66666667%;
            }

            .col-lg-push-4 {
                left: 33.33333333%;
            }

            .col-lg-push-3 {
                left: 25%;
            }

            .col-lg-push-2 {
                left: 16.66666667%;
            }

            .col-lg-push-1 {
                left: 8.33333333%;
            }

            .col-lg-push-0 {
                left: auto;
            }

            .col-lg-offset-12 {
                margin-left: 100%;
            }

            .col-lg-offset-11 {
                margin-left: 91.66666667%;
            }

            .col-lg-offset-10 {
                margin-left: 83.33333333%;
            }

            .col-lg-offset-9 {
                margin-left: 75%;
            }

            .col-lg-offset-8 {
                margin-left: 66.66666667%;
            }

            .col-lg-offset-7 {
                margin-left: 58.33333333%;
            }

            .col-lg-offset-6 {
                margin-left: 50%;
            }

            .col-lg-offset-5 {
                margin-left: 41.66666667%;
            }

            .col-lg-offset-4 {
                margin-left: 33.33333333%;
            }

            .col-lg-offset-3 {
                margin-left: 25%;
            }

            .col-lg-offset-2 {
                margin-left: 16.66666667%;
            }

            .col-lg-offset-1 {
                margin-left: 8.33333333%;
            }

            .col-lg-offset-0 {
                margin-left: 0%;
            }
        }

        /* This should also be a block element, so that it will fill 100% of the .container */
        .content {
            box-sizing: border-box;
            display: block;
            margin: 0 auto;
        }

        /* -------------------------------------
            HEADER, FOOTER, MAIN
        ------------------------------------- */
        .main {
            background: #ffffff;
            border-radius: 3px;
            width: 100%;
        }

        .wrapper {
            box-sizing: border-box;
            padding: 20px;
        }

        .content-block {
            padding-bottom: 10px;
            padding-top: 10px;
        }

        .footer {
            clear: both;
            margin-top: 10px;
            text-align: center;
            width: 100%;
        }

        .footer td,
        .footer p,
        .footer span,
        .footer a {
            color: #999999;
            font-size: 12px;
            text-align: center;
        }

        /* -------------------------------------
            TYPOGRAPHY
        ------------------------------------- */
        h1,
        h2,
        h3,
        h4 {
            color: #000000;
            font-weight: 400;
            line-height: 1.4;
            margin: 0;
            margin-bottom: 30px;
        }

        h1 {
            font-size: 35px;
            font-weight: 300;
            text-align: center;
            text-transform: capitalize;
        }

        p,
        ul,
        ol {
            font-size: 14px;
            font-weight: normal;
            margin: 0;
            margin-bottom: 15px;
        }

        p li,
        ul li,
        ol li {
            list-style-position: inside;
            margin-left: 5px;
        }

        a {
            color: #3498db;
            text-decoration: underline;
        }

        /* -------------------------------------
            BUTTONS
        ------------------------------------- */
        .btn {
            box-sizing: border-box;
            width: 100%;
        }

        .btn > tbody > tr > td {
            padding-bottom: 15px;
        }

        .btn table {
            width: auto;
        }

        .btn table td {
            background-color: #ffffff;
            border-radius: 5px;
            text-align: center;
        }

        .btn a {
            background-color: #ffffff;
            border: solid 1px #3498db;
            border-radius: 5px;
            box-sizing: border-box;
            color: #3498db;
            cursor: pointer;
            display: inline-block;
            font-size: 14px;
            font-weight: bold;
            margin: 0;
            padding: 12px 25px;
            text-decoration: none;
            text-transform: capitalize;
        }

        .btn-primary table td {
            background-color: #3498db;
        }

        .btn-primary a {
            background-color: #3498db;
            border-color: #3498db;
            color: #ffffff;
        }

        /* -------------------------------------
            OTHER STYLES THAT MIGHT BE USEFUL
        ------------------------------------- */
        .last {
            margin-bottom: 0;
        }

        .first {
            margin-top: 0;
        }

        .align-center {
            text-align: center;
        }

        .align-right {
            text-align: right;
        }

        .align-left {
            text-align: left;
        }

        .clear {
            clear: both;
        }

        .mt0 {
            margin-top: 0;
        }

        .mb0 {
            margin-bottom: 0;
        }

        .preheader {
            color: transparent;
            display: none;
            height: 0;
            max-height: 0;
            max-width: 0;
            opacity: 0;
            overflow: hidden;
            mso-hide: all;
            visibility: hidden;
            width: 0;
        }

        .powered-by a {
            text-decoration: none;
        }

        hr {
            border: 0;
            border-bottom: 1px solid #f6f6f6;
            Margin: 20px 0;
        }

        .panelx {
            margin-bottom: 30px;
            background-color: #FFFFFF;
        }

        .panel-default {
            border-color: #eee;
        }

        .panel-heading {
            color: #333;
            background-color: #FAFAFA;
            border-color: #eee;
            padding: 10px 15px;
            border-bottom: 1px solid transparent;
            border-top-left-radius: 3px;
            border-top-right-radius: 3px;
        }

        .panelx .panel-body {
            padding: 15px;
        }

        .panelx .panel-title {
            text-transform: uppercase;
            font-weight: 500;
            margin: 0;
        }

        .label-skill {
            background-color: #1B94D5;
            font-size: 1em;
            color: #ececec;
        }

        .label {
            display: inline;
            padding: .2em .6em .3em;
            font-size: 75%;
            font-weight: 500;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25em;
            margin-right: 5px;
        }

        .candidates-wrapper {

        }

        .candidates-wrapper .candidate-item {
            background-color: #fff;
            padding: 10px 0;
            -webkit-box-shadow: 0 0 0 1px rgba(0, 0, 0, .1);
            box-shadow: 0 0 0 1px rgba(0, 0, 0, .1);
            -webkit-transition: -webkit-box-shadow .2s;
            transition: -webkit-box-shadow .2s;
            transition: box-shadow .2s;
            transition: box-shadow .2s, -webkit-box-shadow .2s;
            border-radius: 2px;
            margin: 7.5px 0;
            min-height: 80px;
            min-height: 120px;
            position: relative;
        }

        .candidate-item .candidate_avatar {
            float: left;
            max-width: 80px !important;
            margin-right: 0 !important;
        }

        .candidate-item .candidate_info {
            padding-left: 12px;
            float: left;
            width: calc(100% - 80px);
        }

        .candidate-item .candidate_info .title {
            margin-top: 0;
            margin-bottom: 0;
            color: #0091cf;
            cursor: pointer;
        }

        .candidate-item .candidate_info .user_name {
            color: #333;
            padding-top: 2px;
        }

        .candidate-item .candidate_info p {
            line-height: 22px;
        }

        .candidate-item .candidate_info .updated-date {
            font-size: 13.5px;
        }

        .candidate-item .candidate_avatar .logo_box {
            width: 65px !important;
            height: 65px !important;
            background-size: contain;
            border: 1px solid #eee;
        }

        .candidate-detail .detail-header {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: horizontal;
            -webkit-box-direction: normal;
            -ms-flex-direction: row;
            flex-direction: row;
        }

        .candidate-detail .detail-header .picture {
            width: 170px;
            position: relative;
        }

        .candidate-detail .detail-header .picture .image-cover {
            width: 150px !important;
            height: 150px !important;
            border: 1px solid #eee;
            padding: 5px;
            margin-top: 50px;
        }

        .candidate-detail .info {
            width: 80%;
            padding-left: 200px;
        }


        /* -------------------------------------
            RESPONSIVE AND MOBILE FRIENDLY STYLES
        ------------------------------------- */
        @media only screen and (max-width: 620px) {
            table[class=body] h1 {
                font-size: 28px !important;
                margin-bottom: 10px !important;
            }

            table[class=body] p,
            table[class=body] ul,
            table[class=body] ol,
            table[class=body] td,
            table[class=body] span,
            table[class=body] a {
                font-size: 16px !important;
            }

            table[class=body] .wrapper,
            table[class=body] .article {
                padding: 10px !important;
            }

            table[class=body] .content {
                padding: 0 !important;
            }

            table[class=body] .container {
                padding: 0 !important;
                width: 100% !important;
            }

            table[class=body] .main {
                border-left-width: 0 !important;
                border-radius: 0 !important;
                border-right-width: 0 !important;
            }

            table[class=body] .btn table {
                width: 100% !important;
            }

            table[class=body] .btn a {
                width: 100% !important;
            }

            table[class=body] .img-responsive {
                height: auto !important;
                max-width: 100% !important;
                width: auto !important;
            }
        }

        /* -------------------------------------
            PRESERVE THESE STYLES IN THE HEAD
        ------------------------------------- */
        @media all {
            .ExternalClass {
                width: 100%;
            }

            .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div {
                line-height: 100%;
            }

            .apple-link a {
                color: inherit !important;
                font-family: inherit !important;
                font-size: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
                text-decoration: none !important;
            }

            .btn-primary table td:hover {
                background-color: #34495e !important;
            }

            .btn-primary a:hover {
                background-color: #34495e !important;
                border-color: #34495e !important;
            }
        }

    </style>
</head>
<body class="">

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="candidate-detail">
                @include('account.inc.candidate-info',['profile'=>$candidate->profile,'is_print'=>true])
                <div class="footer">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="content-block">
                                <span class="apple-link">{!! env('APP_URL') !!}</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
