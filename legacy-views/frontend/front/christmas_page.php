    <style>
        .bee-row,
        .bee-row-content {
            position: relative
        }

        .bee-form .bee-form-row .bee-field button {
            font-size: inherit;
            font-family: inherit
        }

        .bee-button .content,
        .bee-row-22 .bee-col-4 .bee-block-2 .bee-button-container {
            text-align: center
        }

        .bee-row-1 .bee-col-1,
        .bee-row-10 .bee-col-1,
        .bee-row-12 .bee-col-1,
        .bee-row-13 .bee-col-1,
        .bee-row-13 .bee-col-2,
        .bee-row-13 .bee-col-3,
        .bee-row-13 .bee-col-4,
        .bee-row-14 .bee-col-1,
        .bee-row-16 .bee-col-1,
        .bee-row-17 .bee-col-1,
        .bee-row-19 .bee-col-1,
        .bee-row-2 .bee-col-1,
        .bee-row-2 .bee-col-2,
        .bee-row-21 .bee-col-1,
        .bee-row-22 .bee-col-1,
        .bee-row-22 .bee-col-2,
        .bee-row-22 .bee-col-3,
        .bee-row-22 .bee-col-4,
        .bee-row-23 .bee-col-1,
        .bee-row-24 .bee-col-1,
        .bee-row-3 .bee-col-1,
        .bee-row-5 .bee-col-1,
        .bee-row-5 .bee-col-2,
        .bee-row-5 .bee-col-3,
        .bee-row-6 .bee-col-1,
        .bee-row-6 .bee-col-2,
        .bee-row-6 .bee-col-3,
        .bee-row-7 .bee-col-1,
        .bee-row-8 .bee-col-1,
        .bee-row-9 .bee-col-1,
        .bee-row-9 .bee-col-2 {
            padding-top: 5px;
            padding-bottom: 5px
        }

        * {
            box-sizing: border-box
        }

        body,
        h1,
        p {
            margin: 0
        }

        .bee-menu .bee-hamburger-trigger {
            display: none
        }

        .bee-row-content {
            max-width: 1440px;
            margin: 0 auto;
            display: flex
        }

        .bee-row-content.reverse,
        .bee-row-content.reverse .bee-col {
            -moz-transform: scale(1, -1);
            -webkit-transform: scale(1, -1);
            -o-transform: scale(1, -1);
            -ms-transform: scale(1, -1);
            transform: scale(1, -1)
        }

        .bee-row-content .bee-col-w2 {
            flex-basis: 17%
        }

        .bee-row-content .bee-col-w3 {
            flex-basis: 25%
        }

        .bee-row-content .bee-col-w4 {
            flex-basis: 33%
        }

        .bee-row-content .bee-col-w5 {
            flex-basis: 42%
        }

        .bee-row-content .bee-col-w6 {
            flex-basis: 50%
        }

        .bee-row-content .bee-col-w7 {
            flex-basis: 58%
        }

        .bee-row-22 .bee-col-4 .bee-block-2 div.label:not(.inline),
        .bee-row-22 .bee-col-4 .bee-block-2 label:not(.inline),
        .bee-row-content .bee-col-w12 {
            flex-basis: 100%
        }

        .bee-button a,
        .bee-icon .bee-icon-label-right a,
        .bee-menu ul li a {
            text-decoration: none
        }

        .bee-divider,
        .bee-image {
            overflow: auto
        }

        .bee-divider .center,
        .bee-image .bee-center {
            margin: 0 auto
        }

        .bee-row-11 .bee-col-1 .bee-block-1,
        .bee-row-11 .bee-col-2 .bee-block-1,
        .bee-row-11 .bee-col-2 .bee-block-8,
        .bee-row-11 .bee-col-3 .bee-block-1,
        .bee-row-11 .bee-col-3 .bee-block-8,
        .bee-row-15 .bee-col-1 .bee-block-2,
        .bee-row-15 .bee-col-2 .bee-block-2,
        .bee-row-15 .bee-col-3 .bee-block-2,
        .bee-row-15 .bee-col-4 .bee-block-2,
        .bee-row-22 .bee-col-4 .bee-block-2 .bee-form-row:not(.bee-sidelabel) input:not([type=checkbox]):not([type=radio]),
        .bee-row-4 .bee-col-1 .bee-block-7,
        .bee-row-5 .bee-col-1 .bee-block-2,
        .bee-row-6 .bee-col-3 .bee-block-1 {
            width: 100%
        }

        .bee-form .bee-form-row .bee-field {
            padding: 3px;
            display: flex;
            flex: 1;
            flex-wrap: wrap;
            align-items: center
        }

        .bee-form .bee-form-row .bee-field input:not([type=checkbox]):not([type=radio]) {
            flex-grow: 1;
            font-family: inherit;
            font-size: inherit
        }

        .bee-form .bee-form-row .bee-field input[type=checkbox]:not(:first-of-type) {
            margin-left: 15px
        }

        .bee-form .bee-form-row .bee-field .bee-button-container {
            flex-grow: 1
        }

        .bee-form input[type=color] {
            border: none;
            height: 38px
        }

        .bee-form input[type=color]::-webkit-color-swatch-wrapper {
            margin: 0;
            padding: 2px
        }

        .bee-menu ul {
            margin: 0;
            padding: 0
        }

        .bee-form input[type=color]::-webkit-color-swatch {
            margin: 0;
            padding: 0
        }

        .bee-icon {
            display: inline-block;
            vertical-align: middle
        }

        .bee-icon .bee-content {
            display: flex;
            align-items: center
        }

        .bee-image img {
            display: block;
            width: 100%
        }

        .bee-menu .bee-hamburger-controls {
            cursor: pointer;
            display: inline-block;
            position: relative
        }

        .bee-menu .bee-hamburger-controls span {
            display: block;
            position: absolute;
            top: 50%;
            left: 50%;
            background-size: 100%;
            background-repeat: no-repeat;
            transition: .12s ease-in-out
        }

        .bee-menu ul {
            list-style-type: none
        }

        .bee-menu ul.bee-horizontal li {
            display: inline-block
        }

        .bee-social .icon img {
            max-height: 32px
        }

        .bee-text {
            overflow-wrap: anywhere
        }

        .bee-row-1,
        .bee-row-15,
        .bee-row-16,
        .bee-row-18,
        .bee-row-19,
        .bee-row-2,
        .bee-row-24,
        .bee-row-3,
        .bee-row-7 {
            background-repeat: no-repeat
        }

        .bee-row-1 .bee-row-content,
        .bee-row-10 .bee-row-content,
        .bee-row-11 .bee-row-content,
        .bee-row-12 .bee-row-content,
        .bee-row-13 .bee-row-content,
        .bee-row-14 .bee-row-content,
        .bee-row-15 .bee-row-content,
        .bee-row-16 .bee-row-content,
        .bee-row-17 .bee-row-content,
        .bee-row-18 .bee-row-content,
        .bee-row-19 .bee-row-content,
        .bee-row-2 .bee-row-content,
        .bee-row-20 .bee-row-content,
        .bee-row-21 .bee-row-content,
        .bee-row-23 .bee-row-content,
        .bee-row-3 .bee-row-content,
        .bee-row-5 .bee-row-content,
        .bee-row-6 .bee-row-content,
        .bee-row-7 .bee-row-content,
        .bee-row-8 .bee-row-content,
        .bee-row-9 .bee-row-content {
            color: #000;
            background-repeat: no-repeat
        }

        .bee-row-1 .bee-col-1 .bee-block-1,
        .bee-row-13 .bee-col-2 .bee-block-2 .bee-icon-image,
        .bee-row-13 .bee-col-3 .bee-block-2 .bee-icon-image,
        .bee-row-13 .bee-col-4 .bee-block-2 .bee-icon-image,
        .bee-row-18 .bee-col-1 .bee-block-2 .bee-icon-image,
        .bee-row-18 .bee-col-1 .bee-block-4 .bee-icon-image,
        .bee-row-18 .bee-col-1 .bee-block-6 .bee-icon-image,
        .bee-row-18 .bee-col-2 .bee-block-2 .bee-icon-image,
        .bee-row-18 .bee-col-2 .bee-block-4 .bee-icon-image,
        .bee-row-18 .bee-col-2 .bee-block-6 .bee-icon-image,
        .bee-row-18 .bee-col-3 .bee-block-2 .bee-icon-image,
        .bee-row-18 .bee-col-3 .bee-block-4 .bee-icon-image,
        .bee-row-18 .bee-col-3 .bee-block-6 .bee-icon-image,
        .bee-row-3 .bee-col-1 .bee-block-1 {
            padding: 5px
        }

        .bee-row-2 .bee-col-1 .bee-block-1 {
            color: #000;
            text-align: left;
            font-family: inherit;
            font-size: 14px
        }

        .bee-row-2 .bee-col-2 .bee-block-1 {
            text-align: right;
            color: #171b1b;
            padding-top: 10px;
            padding-right: 10px;
            font-family: inherit;
            font-size: 18px
        }

        .bee-row-4 {
            background-repeat: no-repeat;
            background-position: center center;
            background-color: #171b1b;
            /* background-image: url('assets/front/images/christmas/chrisbaner.svg') */
            background-image: url('https://www.grabgreatdeals.com/assets/front/images/christmas/christmasbaner2.svg');
            background-size: cover;
        }

        .bee-row-22 .bee-row-content,
        .bee-row-24 .bee-row-content,
        .bee-row-4 .bee-row-content {
            background-repeat: no-repeat;
            color: #000
        }

        .bee-row-13 .bee-col-2 .bee-block-1,
        .bee-row-13 .bee-col-2 .bee-block-5,
        .bee-row-13 .bee-col-3 .bee-block-1,
        .bee-row-13 .bee-col-3 .bee-block-5,
        .bee-row-13 .bee-col-4 .bee-block-1,
        .bee-row-13 .bee-col-4 .bee-block-5,
        .bee-row-14 .bee-col-1 .bee-block-1,
        .bee-row-14 .bee-col-1 .bee-block-2,
        .bee-row-14 .bee-col-1 .bee-block-5,
        .bee-row-15 .bee-col-1 .bee-block-1,
        .bee-row-15 .bee-col-1 .bee-block-6,
        .bee-row-15 .bee-col-2 .bee-block-1,
        .bee-row-15 .bee-col-2 .bee-block-6,
        .bee-row-15 .bee-col-3 .bee-block-1,
        .bee-row-15 .bee-col-3 .bee-block-6,
        .bee-row-15 .bee-col-4 .bee-block-1,
        .bee-row-15 .bee-col-4 .bee-block-6,
        .bee-row-16 .bee-col-1 .bee-block-1,
        .bee-row-17 .bee-col-1 .bee-block-1,
        .bee-row-17 .bee-col-1 .bee-block-2,
        .bee-row-17 .bee-col-1 .bee-block-5,
        .bee-row-19 .bee-col-1 .bee-block-1,
        .bee-row-20 .bee-col-1 .bee-block-1,
        .bee-row-20 .bee-col-1 .bee-block-2,
        .bee-row-20 .bee-col-1 .bee-block-6,
        .bee-row-21 .bee-col-1 .bee-block-1,
        .bee-row-23 .bee-col-1 .bee-block-1,
        .bee-row-4 .bee-col-1 .bee-block-1,
        .bee-row-4 .bee-col-1 .bee-block-2,
        .bee-row-4 .bee-col-1 .bee-block-4,
        .bee-row-4 .bee-col-1 .bee-block-6,
        .bee-row-5 .bee-col-1 .bee-block-1,
        .bee-row-5 .bee-col-2 .bee-block-1,
        .bee-row-5 .bee-col-2 .bee-block-2,
        .bee-row-5 .bee-col-2 .bee-block-7,
        .bee-row-6 .bee-col-1 .bee-block-1,
        .bee-row-6 .bee-col-1 .bee-block-2,
        .bee-row-6 .bee-col-2 .bee-block-1,
        .bee-row-7 .bee-col-1 .bee-block-1,
        .bee-row-8 .bee-col-1 .bee-block-1,
        .bee-row-8 .bee-col-1 .bee-block-2,
        .bee-row-8 .bee-col-1 .bee-block-8,
        .bee-row-9 .bee-col-1 .bee-block-1 {
            padding: 10px
        }

        .bee-row-4 .bee-col-1 .bee-block-3 {
            width: 100%;
            text-align: center;
            padding: 10px
        }

        .bee-row-15 .bee-col-1 .bee-block-5,
        .bee-row-15 .bee-col-2 .bee-block-5,
        .bee-row-15 .bee-col-3 .bee-block-5,
        .bee-row-15 .bee-col-4 .bee-block-5,
        .bee-row-20 .bee-col-1 .bee-block-5,
        .bee-row-4 .bee-col-1 .bee-block-5,
        .bee-row-8 .bee-col-1 .bee-block-6 {
            text-align: center;
            padding: 10px
        }

        .bee-row-5 {
            background-color: #f5d3ab;
            background-image: url('<?php echo base_url('assets/front/images/christmas/chrisbaner.svg'); ?>');
            background-repeat: no-repeat;
            background-position: top center
        }

        .bee-row-11,
        .bee-row-13,
        .bee-row-20,
        .bee-row-8 {
            background-position: center top
        }

        .bee-row-14 .bee-col-1 .bee-block-3,
        .bee-row-20 .bee-col-1 .bee-block-3,
        .bee-row-5 .bee-col-2 .bee-block-3,
        .bee-row-6 .bee-col-1 .bee-block-3,
        .bee-row-8 .bee-col-1 .bee-block-3 {
            width: 100%;
            text-align: center;
            padding-top: 10px;
            padding-left: 10px
        }

        .bee-row-13 .bee-col-2 .bee-block-4,
        .bee-row-13 .bee-col-3 .bee-block-4,
        .bee-row-13 .bee-col-4 .bee-block-4,
        .bee-row-14 .bee-col-1 .bee-block-4,
        .bee-row-15 .bee-col-1 .bee-block-3,
        .bee-row-15 .bee-col-1 .bee-block-4,
        .bee-row-15 .bee-col-2 .bee-block-3,
        .bee-row-15 .bee-col-2 .bee-block-4,
        .bee-row-15 .bee-col-3 .bee-block-3,
        .bee-row-15 .bee-col-3 .bee-block-4,
        .bee-row-15 .bee-col-4 .bee-block-3,
        .bee-row-15 .bee-col-4 .bee-block-4,
        .bee-row-17 .bee-col-1 .bee-block-4,
        .bee-row-20 .bee-col-1 .bee-block-4,
        .bee-row-5 .bee-col-2 .bee-block-4,
        .bee-row-5 .bee-col-2 .bee-block-5,
        .bee-row-6 .bee-col-1 .bee-block-4,
        .bee-row-6 .bee-col-1 .bee-block-5,
        .bee-row-8 .bee-col-1 .bee-block-4,
        .bee-row-8 .bee-col-1 .bee-block-5 {
            padding: 10px 10px 20px
        }

        .bee-row-11 .bee-col-1 .bee-block-6,
        .bee-row-11 .bee-col-2 .bee-block-12,
        .bee-row-11 .bee-col-2 .bee-block-5,
        .bee-row-11 .bee-col-3 .bee-block-12,
        .bee-row-11 .bee-col-3 .bee-block-5,
        .bee-row-5 .bee-col-2 .bee-block-6,
        .bee-row-6 .bee-col-1 .bee-block-6 {
            text-align: left;
            padding: 10px
        }

        .bee-row-14,
        .bee-row-17,
        .bee-row-6 {
            background-color: #f5d3ab;
            background-repeat: no-repeat;
            background-position: center top
        }

        .bee-row-10,
        .bee-row-11,
        .bee-row-12,
        .bee-row-21,
        .bee-row-22,
        .bee-row-23,
        .bee-row-8,
        .bee-row-9 {
            background-color: #171b1b;
            background-repeat: no-repeat
        }

        .bee-row-8 {
            background-image: none
        }

        .bee-row-8 .bee-col-1 .bee-block-7 {
            width: 100%;
            padding: 25px 10px 10px
        }

        .bee-row-13 .bee-col-2 .bee-block-3,
        .bee-row-13 .bee-col-3 .bee-block-3,
        .bee-row-13 .bee-col-4 .bee-block-3,
        .bee-row-9 .bee-col-1 .bee-block-2 {
            width: 100%;
            text-align: center;
            padding-top: 10px;
            padding-bottom: 15px;
            padding-left: 10px
        }

        .bee-row-10 .bee-col-1 .bee-block-1,
        .bee-row-11 .bee-col-1 .bee-block-7,
        .bee-row-12 .bee-col-1 .bee-block-1 {
            padding: 30px
        }

        .bee-row-11 .bee-col-1 {
            background-color: #fff;
            border-bottom: 14px solid #171b1b;
            border-left: 14px solid #171b1b;
            border-right: 14px solid #171b1b;
            border-top: 14px solid #171b1b;
            padding-bottom: 5px
        }

        .bee-row-11 .bee-col-1 .bee-block-2,
        .bee-row-11 .bee-col-2 .bee-block-13,
        .bee-row-11 .bee-col-2 .bee-block-6,
        .bee-row-11 .bee-col-3 .bee-block-13,
        .bee-row-11 .bee-col-3 .bee-block-6 {
            padding: 20px
        }

        .bee-row-11 .bee-col-1 .bee-block-3,
        .bee-row-11 .bee-col-2 .bee-block-2,
        .bee-row-11 .bee-col-2 .bee-block-9,
        .bee-row-11 .bee-col-3 .bee-block-2,
        .bee-row-11 .bee-col-3 .bee-block-9 {
            padding: 30px 10px 10px 20px
        }

        .bee-row-11 .bee-col-1 .bee-block-4,
        .bee-row-11 .bee-col-2 .bee-block-10,
        .bee-row-11 .bee-col-2 .bee-block-3,
        .bee-row-11 .bee-col-3 .bee-block-10,
        .bee-row-11 .bee-col-3 .bee-block-3 {
            width: 100%;
            text-align: center;
            padding-top: 10px;
            padding-bottom: 15px;
            padding-left: 20px
        }

        .bee-row-11 .bee-col-1 .bee-block-5 {
            padding: 10px 10px 30px 20px
        }

        .bee-row-11 .bee-col-2,
        .bee-row-11 .bee-col-3 {
            background-color: #fff;
            border-top: 13px solid #171b1b;
            border-right: 13px solid #171b1b;
            border-bottom: 13px solid #171b1b;
            border-left: 13px solid #171b1b;
            padding-bottom: 5px
        }

        .bee-row-11 .bee-col-2 .bee-block-11,
        .bee-row-11 .bee-col-2 .bee-block-4,
        .bee-row-11 .bee-col-3 .bee-block-11,
        .bee-row-11 .bee-col-3 .bee-block-4 {
            padding: 10px 10px 20px 20px
        }

        .bee-row-13 {
            background-image: url('<?php echo base_url('assets/front/images/christmas/christmasbaner2.svg'); ?>');
            background-repeat: repeat
        }

        .bee-row-13 .bee-col-2 {
            background-color: #fff
        }

        .bee-row-13 .bee-col-2 .bee-block-2,
        .bee-row-13 .bee-col-3 .bee-block-2,
        .bee-row-13 .bee-col-4 .bee-block-2,
        .bee-row-18 .bee-col-1 .bee-block-2,
        .bee-row-18 .bee-col-2 .bee-block-2,
        .bee-row-18 .bee-col-3 .bee-block-2 {
            color: #000;
            text-align: center;
            font-family: inherit;
            font-size: 14px
        }

        .bee-row-13 .bee-col-3 {
            background-color: #9ead8d
        }

        .bee-row-13 .bee-col-4 {
            background-color: #956d59
        }

        .bee-row-15 .bee-col-1,
        .bee-row-15 .bee-col-3 {
            border-bottom: 8px solid #171b1b;
            border-left: 8px solid #171b1b;
            border-right: 8px solid #171b1b;
            border-top: 8px solid #171b1b;
            padding-bottom: 5px;
            padding-top: 5px
        }

        .bee-row-15 .bee-col-2,
        .bee-row-15 .bee-col-4 {
            background-color: #171b1b;
            border-top: 8px solid #f5d3ab;
            border-right: 8px solid #f5d3ab;
            border-bottom: 8px solid #f5d3ab;
            border-left: 8px solid #f5d3ab;
            padding-bottom: 5px;
            padding-top: 5px
        }

        .bee-row-17 .bee-col-1 .bee-block-3 {
            width: 100%;
            text-align: center;
            padding-top: 10px;
            padding-bottom: 10px;
            padding-left: 10px
        }

        .bee-row-18 .bee-col-1,
        .bee-row-18 .bee-col-3 {
            background-color: #fff;
            border-bottom: 16px solid #f5d3ab;
            border-left: 0 solid #f5d3ab;
            border-right: 0px solid #f5d3ab;
            border-top: 16px solid #f5d3ab;
            padding-bottom: 5px;
            padding-top: 5px
        }

        .bee-row-18 .bee-col-1 .bee-block-1,
        .bee-row-18 .bee-col-1 .bee-block-7,
        .bee-row-18 .bee-col-2 .bee-block-1,
        .bee-row-18 .bee-col-2 .bee-block-7,
        .bee-row-18 .bee-col-3 .bee-block-1 {
            padding: 25px
        }

        .bee-row-18 .bee-col-1 .bee-block-3,
        .bee-row-18 .bee-col-1 .bee-block-5,
        .bee-row-18 .bee-col-2 .bee-block-3,
        .bee-row-18 .bee-col-2 .bee-block-5,
        .bee-row-18 .bee-col-3 .bee-block-3,
        .bee-row-18 .bee-col-3 .bee-block-5 {
            padding: 25px 10px 20px 20px
        }

        .bee-row-18 .bee-col-1 .bee-block-4,
        .bee-row-18 .bee-col-2 .bee-block-4,
        .bee-row-18 .bee-col-3 .bee-block-4 {
            color: #000;
            text-align: center;
            padding-right: 20px;
            padding-left: 20px;
            font-family: inherit;
            font-size: 14px
        }

        .bee-row-18 .bee-col-1 .bee-block-6,
        .bee-row-18 .bee-col-2 .bee-block-6,
        .bee-row-18 .bee-col-3 .bee-block-6 {
            color: #000;
            text-align: center;
            padding-left: 20px;
            font-family: inherit;
            font-size: 14px
        }

        .bee-row-18 .bee-col-2 {
            background-color: #9ead8d;
            padding-bottom: 5px;
            padding-top: 5px
        }

        .bee-row-20 {
            background-color: #001b25;
            background-repeat: no-repeat
        }

        .bee-row-20 .bee-col-1 {
            padding-top: 5px
        }

        .bee-row-20 .bee-col-1 .bee-block-7 {
            width: 100%;
            padding-top: 25px;
            padding-right: 25px;
            padding-left: 25px
        }

        .bee-row-22 .bee-col-1 .bee-block-1 {
            width: 100%;
            padding-bottom: 10px;
            padding-left: 20px
        }

        .bee-row-22 .bee-col-1 .bee-block-2,
        .bee-row-22 .bee-col-2 .bee-block-2,
        .bee-row-22 .bee-col-2 .bee-block-3,
        .bee-row-22 .bee-col-2 .bee-block-4,
        .bee-row-22 .bee-col-2 .bee-block-5,
        .bee-row-22 .bee-col-2 .bee-block-6,
        .bee-row-22 .bee-col-3 .bee-block-2,
        .bee-row-22 .bee-col-3 .bee-block-3 {
            padding: 10px 20px
        }

        .bee-row-22 .bee-col-2 .bee-block-1,
        .bee-row-22 .bee-col-3 .bee-block-1,
        .bee-row-22 .bee-col-4 .bee-block-1 {
            padding-left: 20px;
            text-align: center;
            width: 100%
        }

        .bee-row-22 .bee-col-3 .bee-block-4 {
            padding: 10px;
            text-align: left
        }

        .bee-row-22 .bee-col-4 .bee-block-2 {
            font-size: 14px;
            padding: 10px;
            font-family: inherit;
            text-align: center
        }

        .bee-row-24 .bee-col-1 .bee-block-1 {
            color: #9d9d9d;
            font-family: inherit;
            font-size: 15px;
            padding-bottom: 5px;
            padding-top: 5px;
            text-align: center
        }

        .bee-row-2 .bee-col-2 .bee-block-1 li {
            padding: 5px 10px 5px 15px
        }

        .bee-row-2 .bee-col-2 .bee-block-1 li a {
            color: #171b1b
        }

        .bg-baner {
            height: 120vh;
        }

        @media (max-width:1260px) {
            .bg-baner {
                height: 110vh;
            }
        }

        @media (max-width:1140px) {
            .bg-baner {
                height: 100vh;
            }
        }

        @media (max-width:1010px) {
            .bg-baner {
                height: 90vh;
            }
        }

        @media (max-width:910px) {
            .bg-baner {
                height: 85vh;
            }
        }

        @media (max-width:830px) {
            .bg-baner {
                height: 80vh;
            }
        }

        @media (max-width:768px) {
            .bg-baner {
                height: 70vh;
            }

            .bee-form form {
                width: 100% !important
            }

            .bee-menu ul.with-bee-hamburger {
                display: none;
                padding: 5px 0;
                position: relative;
                top: -4px
            }

            .bee-menu ul.with-bee-hamburger li {
                display: block;
                text-align: center
            }

            .bee-menu ul.with-bee-hamburger li a {
                text-decoration: none
            }

            .bee-menu ul.with-bee-hamburger span {
                display: none
            }

            #bee-hamburger-memu-r1c1m0:checked~ul,
            .bee-row-content:not(.no_stack) {
                display: block
            }

            .bee-row-2 .bee-col-2 .bee-block-1 .bee-hamburger-controls {
                width: 36px;
                height: 36px;
                background-color: #171b1b;
                border-radius: 0
            }

            .bee-row-2 .bee-col-2 .bee-block-1 .bee-hamburger-controls span {
                width: 18px;
                height: 18px
            }

            .bee-row-2 .bee-col-2 .bee-block-1 .bee-hamburger-controls span.bee-hamburger-open {
                background-image: url("data:image/svg+xml;base64,PHN2ZyBoZWlnaHQ9IjY0IiB2aWV3Qm94PSIwIDAgNjQgNjQiIHdpZHRoPSI2NCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSIjZmZmZmZmIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxyZWN0IGhlaWdodD0iMTIiIHJ4PSI2IiB3aWR0aD0iNjQiLz48cmVjdCBoZWlnaHQ9IjEyIiByeD0iNiIgd2lkdGg9IjY0IiB5PSI1MiIvPjxyZWN0IGhlaWdodD0iMTIiIHJ4PSI2IiB3aWR0aD0iNjQiIHk9IjI2Ii8+PC9nPjwvc3ZnPg==");
                transform: translate(-50%, -50%) scaleY(1)
            }

            .bee-row-2 .bee-col-2 .bee-block-1 .bee-hamburger-controls span.bee-hamburger-close {
                background-image: url("data:image/svg+xml;base64,PHN2ZyBoZWlnaHQ9IjY0IiB2aWV3Qm94PSIwIDAgNjQgNjQiIHdpZHRoPSI2NCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSIjZmZmZmZmIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxyZWN0IGhlaWdodD0iMTIiIHJ4PSI2IiB0cmFuc2Zvcm09Im1hdHJpeCgtLjcwNzEwNjc4IC0uNzA3MTA2NzggLjcwNzEwNjc4IC0uNzA3MTA2NzggMzEuOTkxMzc4IDc3LjIzNDAxOSkiIHdpZHRoPSI4MiIgeD0iLTkuMDA4NjIyIiB5PSIyNS45OTEzNzgiLz48cmVjdCBoZWlnaHQ9IjEyIiByeD0iNiIgdHJhbnNmb3JtPSJtYXRyaXgoLS43MDcxMDY3OCAuNzA3MTA2NzggLS43MDcxMDY3OCAtLjcwNzEwNjc4IDc3LjgxOTgwNiAzMi4yMzQwMTkpIiB3aWR0aD0iODIiIHg9Ii04Ljc2NTk4MSIgeT0iMjYuMjM0MDE5Ii8+PC9nPjwvc3ZnPg==");
                transform: translate(-50%, -50%) scaleY(0)
            }

            .bee-row-2 .bee-col-2 .bee-block-1 ul.with-bee-hamburger {
                background-color: #171b1b
            }

            .bee-row-2 .bee-col-2 .bee-block-1 ul.with-bee-hamburger li,
            .bee-row-2 .bee-col-2 .bee-block-1 ul.with-bee-hamburger li a {
                color: #fff
            }

            #bee-hamburger-memu-r1c1m0:checked~.bee-hamburger-controls .bee-hamburger-open {
                transform: translate(-50%, -50%) scaleY(0)
            }

            #bee-hamburger-memu-r1c1m0:checked~.bee-hamburger-controls .bee-hamburger-close {
                transform: translate(-50%, -50%) scaleY(1)
            }
        }

        @media (max-width:620px) {
            .bg-baner {
                height: 65vh;
            }
        }

        @media (max-width:468px) {
            .bg-baner {
                height: 30vh;
            }
        }

        .bee-row-2 .bee-col-1 .bee-block-1 .bee-icon-image {
            padding: 10px 5px 5px 15px
        }

        .bee-row-13 .bee-col-2 .bee-block-2 .bee-icon:not(.bee-icon-first) .bee-content,
        .bee-row-13 .bee-col-3 .bee-block-2 .bee-icon:not(.bee-icon-first) .bee-content,
        .bee-row-13 .bee-col-4 .bee-block-2 .bee-icon:not(.bee-icon-first) .bee-content,
        .bee-row-18 .bee-col-1 .bee-block-2 .bee-icon:not(.bee-icon-first) .bee-content,
        .bee-row-18 .bee-col-1 .bee-block-4 .bee-icon:not(.bee-icon-first) .bee-content,
        .bee-row-18 .bee-col-1 .bee-block-6 .bee-icon:not(.bee-icon-first) .bee-content,
        .bee-row-18 .bee-col-2 .bee-block-2 .bee-icon:not(.bee-icon-first) .bee-content,
        .bee-row-18 .bee-col-2 .bee-block-4 .bee-icon:not(.bee-icon-first) .bee-content,
        .bee-row-18 .bee-col-2 .bee-block-6 .bee-icon:not(.bee-icon-first) .bee-content,
        .bee-row-18 .bee-col-3 .bee-block-2 .bee-icon:not(.bee-icon-first) .bee-content,
        .bee-row-18 .bee-col-3 .bee-block-4 .bee-icon:not(.bee-icon-first) .bee-content,
        .bee-row-18 .bee-col-3 .bee-block-6 .bee-icon:not(.bee-icon-first) .bee-content,
        .bee-row-2 .bee-col-1 .bee-block-1 .bee-icon:not(.bee-icon-first) .bee-content,
        .bee-row-24 .bee-col-1 .bee-block-1 .bee-icon:not(.bee-icon-first) .bee-content {
            margin-left: 0
        }

        .bee-row-2 .bee-col-1 .bee-block-1 .bee-icon::not(.bee-icon-last) .bee-content {
            margin-right: 0
        }

        .bee-row-13 .bee-col-2 .bee-block-2 .bee-icon::not(.bee-icon-last) .bee-content {
            margin-right: 0
        }

        .bee-row-13 .bee-col-3 .bee-block-2 .bee-icon::not(.bee-icon-last) .bee-content {
            margin-right: 0
        }

        .bee-row-13 .bee-col-4 .bee-block-2 .bee-icon::not(.bee-icon-last) .bee-content {
            margin-right: 0
        }

        .bee-row-18 .bee-col-1 .bee-block-2 .bee-icon::not(.bee-icon-last) .bee-content {
            margin-right: 0
        }

        .bee-row-18 .bee-col-1 .bee-block-4 .bee-icon::not(.bee-icon-last) .bee-content {
            margin-right: 0
        }

        .bee-row-18 .bee-col-1 .bee-block-6 .bee-icon::not(.bee-icon-last) .bee-content {
            margin-right: 0
        }

        .bee-row-18 .bee-col-2 .bee-block-2 .bee-icon::not(.bee-icon-last) .bee-content {
            margin-right: 0
        }

        .bee-row-18 .bee-col-2 .bee-block-4 .bee-icon::not(.bee-icon-last) .bee-content {
            margin-right: 0
        }

        .bee-row-18 .bee-col-2 .bee-block-6 .bee-icon::not(.bee-icon-last) .bee-content {
            margin-right: 0
        }

        .bee-row-18 .bee-col-3 .bee-block-2 .bee-icon::not(.bee-icon-last) .bee-content {
            margin-right: 0
        }

        .bee-row-18 .bee-col-3 .bee-block-4 .bee-icon::not(.bee-icon-last) .bee-content {
            margin-right: 0
        }

        .bee-row-18 .bee-col-3 .bee-block-6 .bee-icon::not(.bee-icon-last) .bee-content {
            margin-right: 0
        }

        .bee-row-24 .bee-col-1 .bee-block-1 .bee-icon-image {
            padding: 5px 6px 5px 5px
        }

        .bee-row-24 .bee-col-1 .bee-block-1 .bee-icon::not(.bee-icon-last) .bee-content {
            margin-right: 0
        }

        .bee-row-22 .bee-col-4 .bee-block-2 form {
            display: inline-block;
            width: 100%
        }

        .bee-row-22 .bee-col-4 .bee-block-2 div.label,
        .bee-row-22 .bee-col-4 .bee-block-2 label {
            color: #fff;
            line-height: 200%;
            text-align: left;
            display: block
        }

        .bee-row-22 .bee-col-4 .bee-block-2 ::-webkit-input-placeholder {
            color: #000
        }

        .bee-row-22 .bee-col-4 .bee-block-2 :-moz-placeholder {
            color: #000
        }

        .bee-row-22 .bee-col-4 .bee-block-2 ::-moz-placeholder {
            color: #000
        }

        .bee-row-22 .bee-col-4 .bee-block-2 :-ms-input-placeholder {
            color: #000
        }

        .bee-row-22 .bee-col-4 .bee-block-2 .bee-field>label:first-child,
        .bee-row-22 .bee-col-4 .bee-block-2 div.label {
            padding: 3px
        }

        .bee-row-22 .bee-col-4 .bee-block-2 input:not([type=checkbox]):not([type=radio]):not([type=image]) {
            color: #000;
            background-color: #fff;
            border-top: 1px solid transparent;
            border-right: 1px solid transparent;
            border-bottom: 1px solid transparent;
            border-left: 1px solid transparent;
            padding: 5px;
            border-radius: 4px;
            min-height: 38px
        }

        .bee-row-22 .bee-col-4 .bee-block-2 input:not([type=checkbox]):not([type=radio]):focus {
            outline-color: #3aaee0
        }

        .bee-row-22 .bee-col-4 .bee-block-2 button {
            background-color: #c92727;
            border-radius: 4px;
            border-top: 0 solid transparent;
            border-right: 0px solid transparent;
            border-bottom: 0 solid transparent;
            border-left: 0 solid transparent;
            color: #fff;
            line-height: 200%;
            width: 100%;
            padding: 5px 20px
        }

        .special-price .price {
            font-size: 16px;
            color: #009698;
            font-weight: bold;
        }
    </style>
    <div class="bee-page-container">
        <div class="bee-row bee-row-4 bg-baner">
            <div class="bee-row-content">
                <div class="bee-col bee-col-1 bee-col-w12">
                    <div class="bee-block bee-block-1 bee-divider">
                        <div class="spacer" style="height:50px;"></div>
                    </div>
                    <div class="bee-block bee-block-2 bee-divider">
                        <div class="spacer" style="height:35px;"></div>
                    </div>
                    <div class="bee-block bee-block-3 bee-heading">
                        <!-- <h1 style="color:#ffffff;font-size:62px;font-family:'Permanent Marker', Impact, Charcoal, sans-serif;line-height:120%;text-align:center;direction:ltr;font-weight:normal;letter-spacing:normal;margin-top:0;margin-bottom:0;"><strong> Merry</strong><strong> Christmas </strong> </h1> -->
                    </div>
                    <div class="bee-block bee-block-4 bee-text">
                        <div class="bee-text-content" style="font-size: 14px; line-height: 150%; color: #f5f5f5; font-family: inherit;">
                            <!-- <p style="font-size: 14px; line-height: 21px; text-align: center;"><span style="font-size: 26px; line-height: 39px;">Enjoy 10% off on all products</span></p> -->
                        </div>
                    </div>
                    <div class="bee-block bee-block-5 bee-button">
                        <!-- <div class="bee-button-content" style="font-size: 14px; line-height: 28px; font-family: inherit; background-color: #ffd8d8; border-radius: 4px; border-top: 1px solid #C92727; border-right: 1px solid #C92727; border-bottom: 1px solid #C92727; border-left: 1px solid #C92727; color: #c92727; padding-top: 5px; padding-right: 40px; padding-bottom: 5px; padding-left: 40px; width: auto; max-width: 100%; display: inline-block;"><span style="font-size: 16px; line-height: 200%; word-break: break-word;"><span style="font-size: 22px; line-height: 44px;">Coupon Code: GGDCRMS</span></span></div> -->
                    </div>
                    <div class="bee-block bee-block-6 bee-text">
                        <div class="bee-text-content" style="font-size: 14px; line-height: 150%; color: #f5f5f5; font-family: inherit;">
                            <!-- <p style="font-size: 14px; line-height: 21px; text-align: center;"><span style="font-size: 15px; line-height: 22px;">*The code is valid until 06.01.2023*</span></p> -->
                        </div>
                    </div>
                    <!-- <div class="bee-block bee-block-7 bee-image"><img alt="Chocolate box" class="bee-center bee-fixedwidth" src="<?php echo base_url('assets/front/images/christmas/chrisbaner.svg'); ?>" style="max-width:504px;" /></div> -->
                </div>
            </div>
        </div>
        <div class="bee-row bee-row-5">
            <?php $dbselc1 = $this->db->select('pro_title,pro_title_slug,pro_price,pro_offer_price,pro_desc,pro_image')->from('tbl_product')->where('pro_id', 1711)->get()->row(); ?>
            <div class="bee-row-content">
                <div class="bee-col bee-col-1 bee-col-w6">
                    <div class="bee-block bee-block-1 bee-divider">
                        <div class="spacer" style="height:65px;"></div>
                    </div>
                    <div class="bee-block bee-block-2 bee-image"><img alt="Mixing chocolate" class="bee-center bee-fixedwidth" src="<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $dbselc1->pro_image ?>" style="max-width:504px;" /></div>
                </div>
                <div class="bee-col bee-col-2 bee-col-w4">
                    <div class="bee-block bee-block-1 bee-divider">
                        <div class="spacer" style="height:60px;"></div>
                    </div>
                    <div class="bee-block bee-block-3 bee-heading">
                        <h4 style="color:#333333;font-size:30px;font-family:Helvetica Neue, Helvetica, Arial, sans-serif;line-height:120%;text-align:left;direction:ltr;font-weight:normal;letter-spacing:normal;margin-top:0;margin-bottom:0;"><strong><?php echo substr($dbselc1->pro_title, 0, 50); ?></strong> </h4>
                    </div>
                    <div class="bee-block bee-block-4 bee-text">
                        <div class="bee-text-content" style="font-size: 14px; line-height: 150%; color: #333333; font-family: inherit;">
                            <p style="font-size: 14px; line-height: 21px; text-align: left;"><span style="font-size: 20px; line-height: 30px;">Electrical climbing ladder commanding of battery with a great Santa facial expression, made of high-quality PVC & plush fabric material with easy installation can be decor-ed at your place & also it could be the best gift material.</span></p>
                        </div>
                    </div>
                    <div class="bee-block bee-block-5 bee-text">
                        <div class="item-price">
                            <?php if (!empty($dbselc1->pro_offer_price)) { ?>
                                <div class="price-box">
                                    <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"><?php echo currencyConverterFunction($dbselc1->pro_offer_price); ?> </span> </p>
                                    <p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price"><?php echo currencyConverterFunction($dbselc1->pro_price); ?> </span> </p>
                                </div>
                            <?php } else { ?>
                                <div class="price-box">
                                    <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"> <?php echo currencyConverterFunction($dbselc1->pro_price); ?> </span> </p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="bee-block bee-block-6 bee-button"><a class="bee-button-content" href="<?php echo base_url() ?>product-details/<?php echo $dbselc1->pro_title_slug; ?>" style="font-size: 14px; line-height: 28px; font-family: inherit; background-color: #171b1b; border-radius: 4px; border-top: 1px solid #171B1B; border-right: 1px solid #171B1B; border-bottom: 1px solid #171B1B; border-left: 1px solid #171B1B; color: #ffffff; padding-top: 5px; padding-right: 40px; padding-bottom: 5px; padding-left: 40px; width: auto; max-width: 100%; display: inline-block;"><span style="font-size: 16px; line-height: 200%; word-break: break-word;">Explore Now!</span></a></div>
                    <div class="bee-block bee-block-7 bee-divider">
                        <div class="spacer" style="height:60px;"></div>
                    </div>
                </div>
                <div class="bee-col bee-col-3 bee-col-w2">
                    <div class="bee-block bee-block-1 bee-divider">
                        <div class="spacer" style="height:0px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bee-row bee-row-6">
            <?php $dbselc2 = $this->db->select('pro_title,pro_title_slug,pro_price,pro_offer_price,pro_desc,pro_image')->from('tbl_product')->where('pro_id', 1717)->get()->row(); ?>
            <div class="bee-row-content reverse">
                <div class="bee-col bee-col-1 bee-col-w5">
                    <div class="bee-block bee-block-1 bee-divider">
                        <div class="spacer" style="height:45px;"></div>
                    </div>
                    <div class="bee-block bee-block-3 bee-heading">
                        <h4 style="color:#333333;font-size:30px;font-family:Helvetica Neue, Helvetica, Arial, sans-serif;line-height:120%;text-align:left;direction:ltr;font-weight:normal;letter-spacing:normal;margin-top:0;margin-bottom:0;"><strong><?php echo substr($dbselc2->pro_title, 0, 50); ?></strong> </h4>
                    </div>
                    <div class="bee-block bee-block-4 bee-text">
                        <div class="bee-text-content" style="font-size: 14px; line-height: 150%; color: #333333; font-family: inherit;">
                            <p style="font-size: 14px; line-height: 21px; text-align: left;"><span style="font-size: 20px; line-height: 30px;">The Christmas cookie cutter makes an awesome cookie, is easy to mold your cookie, is made of ABS material, and gives awesome designing cookies for Xmas.
                                </span></p>
                        </div>
                    </div>
                    <div class="bee-block bee-block-5 bee-text">
                        <div class="item-price">
                            <?php if (!empty($dbselc2->pro_offer_price)) { ?>
                                <div class="price-box">
                                    <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"><?php echo currencyConverterFunction($dbselc2->pro_offer_price); ?> </span> </p>
                                    <p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price"><?php echo currencyConverterFunction($dbselc2->pro_price); ?> </span> </p>
                                </div>
                            <?php } else { ?>
                                <div class="price-box">
                                    <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"> <?php echo currencyConverterFunction($dbselc2->pro_price); ?> </span> </p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="bee-block bee-block-6 bee-button"><a class="bee-button-content" href="<?php echo base_url() ?>product-details/<?php echo $dbselc2->pro_title_slug; ?>" style="font-size: 14px; line-height: 28px; font-family: inherit; background-color: #171b1b; border-radius: 4px; border-top: 1px solid #171B1B; border-right: 1px solid #171B1B; border-bottom: 1px solid #171B1B; border-left: 1px solid #171B1B; color: #ffffff; padding-top: 5px; padding-right: 40px; padding-bottom: 5px; padding-left: 40px; width: auto; max-width: 100%; display: inline-block;"><span style="font-size: 16px; line-height: 200%; word-break: break-word;">Explore Now!</span></a></div>
                </div>
                <div class="bee-col bee-col-2 bee-col-w2">
                    <div class="bee-block bee-block-1 bee-divider">
                        <div class="spacer" style="height:60px;"></div>
                    </div>
                    <div class="bee-block bee-block-2 bee-divider">
                        <div class="spacer" style="height:0px;"></div>
                    </div>
                </div>
                <div class="bee-col bee-col-3 bee-col-w5">
                    <div class="bee-block bee-block-1 bee-image"><img alt="White chocolate" class="bee-center bee-fixedwidth" src="<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $dbselc2->pro_image ?>" style="max-width:480px;" /></div>
                </div>
            </div>
        </div>
        <div class="bee-row bee-row-8">
            <div class="bee-row-content">
                <?php $dbselc3 = $this->db->select('pro_title,pro_title_slug,pro_price,pro_offer_price,pro_desc,pro_image')->from('tbl_product')->where('pro_id', 1707)->get()->row(); ?>
                <div class="bee-col bee-col-1 bee-col-w12">
                    <div class="bee-block bee-block-1 bee-divider">
                        <div class="spacer" style="height:70px;"></div>
                    </div>
                    <div class="bee-block bee-block-3 bee-heading">
                        <h4 style="color:#ffffff;font-size:30px;font-family:Helvetica Neue, Helvetica, Arial, sans-serif;line-height:120%;text-align:center;direction:ltr;font-weight:normal;letter-spacing:normal;margin-top:0;margin-bottom:0;"><strong><?php echo substr($dbselc3->pro_title, 0, 50); ?></strong> </h4>
                    </div>
                    <div class="bee-block bee-block-4 bee-text">
                        <div class="bee-text-content" style="font-size: 14px; line-height: 150%; color: #c2c2c2; font-family: inherit;">
                            <p style="font-size: 14px; line-height: 21px; text-align: center;"><span style="font-size: 16px; line-height: 24px;">USB rechargeable bedside lamp with diamonds, casting shadows design makes a luxurious atmosphere made of PC transparent material automatically shut down your lamp’s charge which will protect your lamp.
                                </span></p>
                        </div>
                    </div>
                    <div class="bee-block bee-block-5 bee-text">
                        <div class="item-price">
                            <?php if (!empty($dbselc3->pro_offer_price)) { ?>
                                <div class="price-box">
                                    <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"><?php echo currencyConverterFunction($dbselc3->pro_offer_price); ?> </span> </p>
                                    <p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price"><?php echo currencyConverterFunction($dbselc3->pro_price); ?> </span> </p>
                                </div>
                            <?php } else { ?>
                                <div class="price-box">
                                    <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"> <?php echo currencyConverterFunction($dbselc3->pro_price); ?> </span> </p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="bee-block bee-block-6 bee-button"><a class="bee-button-content" href="<?php echo base_url() ?>product-details/<?php echo $dbselc3->pro_title_slug; ?>" style="font-size: 14px; line-height: 28px; font-family: inherit; background-color: #c92727; border-radius: 4px; border-top: 1px solid #C92727; border-right: 1px solid #C92727; border-bottom: 1px solid #C92727; border-left: 1px solid #C92727; color: #ffffff; padding-top: 5px; padding-right: 40px; padding-bottom: 5px; padding-left: 40px; width: auto; max-width: 100%; display: inline-block;"><span style="font-size: 16px; line-height: 200%; word-break: break-word;">Explore Now!</span></a></div>
                    <div class="bee-block bee-block-7 bee-image"><img alt="Chocolate Christmas Basket" class="bee-center bee-fixedwidth bee-fullwidthOnMobile" src="<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $dbselc3->pro_image ?>" style="max-width:504px;" /></div>
                    <div class="bee-block bee-block-8 bee-divider">
                        <div class="spacer" style="height:55px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bee-row bee-row-9">
            <div class="bee-row-content">
                <div class="bee-col bee-col-1 bee-col-w5">
                    <div class="bee-block bee-block-1 bee-text">
                        <div class="bee-text-content" style="font-size: 14px; line-height: 150%; color: #ffffff; font-family: inherit;">
                            <p style="font-size: 14px; line-height: 21px; text-align: left;"><strong style=""><span style="font-size: 20px; line-height: 30px;">Trending products</span></strong></p>
                        </div>
                    </div>
                    <div class="bee-block bee-block-2 bee-heading">
                        <h1 style="color:#ffffff;font-size:30px;font-family:Helvetica Neue, Helvetica, Arial, sans-serif;line-height:120%;text-align:left;direction:ltr;font-weight:normal;letter-spacing:normal;margin-top:0;margin-bottom:0;">Explore Best &amp;  Trending Products For Christmas </h1>
                    </div>
                </div>
                <div class="bee-col bee-col-2 bee-col-w7">
                    <div class="bee-block bee-block-1 bee-divider">
                        <div class="spacer" style="height:0px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bee-row bee-row-10">
            <div class="bee-row-content">
                <div class="bee-col bee-col-1 bee-col-w12">
                    <div class="bee-block bee-block-1 bee-divider">
                        <div class="spacer" style="height:0px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bee-row bee-row-11">
            <div class="bee-row-content">
                <div class="bee-col bee-col-1 bee-col-w6">
                    <?php $dbselc3 = $this->db->select('pro_title,pro_title_slug,pro_price,pro_offer_price,pro_desc,pro_image')->from('tbl_product')->where('pro_id', 1678)->get()->row(); ?>
                    <div class="bee-block bee-block-1 bee-image"><img alt="Chocolate in Box" class="bee-center bee-fixedwidth bee-fullwidthOnMobile" src="<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $dbselc3->pro_image ?>" style="max-width:692px;" /></div>
                    <div class="bee-block bee-block-2 bee-divider">
                        <div class="spacer" style="height:0px;"></div>
                    </div>

                    <div class="bee-block bee-block-4 bee-heading">
                        <h4 style="color:#333333;font-size:32px;font-family:Helvetica Neue, Helvetica, Arial, sans-serif;line-height:120%;text-align:left;direction:ltr;font-weight:normal;letter-spacing:normal;margin-top:0;margin-bottom:0;"><strong><?php echo substr($dbselc3->pro_title, 0, 50); ?></strong> </h4>
                    </div>
                    <div class="bee-block bee-block-5 bee-text">
                        <div class="bee-text-content" style="font-size: 14px; line-height: 150%; color: #333333; font-family: inherit;">
                            <p style="font-size: 14px; line-height: 21px; text-align: left;"><span style="font-size: 20px; line-height: 30px;">This Santa Clause snowflake LED light with a bendable design is easy to decorate your Christmas trees, made with 3 AA batteries grabs all the attention & highlighted your Xmas party.
                                </span></p>
                        </div>
                    </div>
                    <div class="bee-block bee-block-6 bee-button">
                        <div class="bee-button-content" style="font-size: 14px; line-height: 28px; font-family: inherit; background-color: #171b1b; border-radius: 4px; border-top: 1px solid #171B1B; border-right: 1px solid #171B1B; border-bottom: 1px solid #171B1B; border-left: 1px solid #171B1B; color: #ffffff; padding-top: 5px; padding-right: 40px; padding-bottom: 5px; padding-left: 40px; width: auto; max-width: 100%; display: inline-block;"><span style="font-size: 16px; line-height: 200%; word-break: break-word;"><a href="<?php echo base_url() ?>product-details/<?php echo $dbselc3->pro_title_slug; ?>" style="color:#ffffff">Explore Now!</a> </span></div>
                    </div>
                    <div class="bee-block bee-block-7 bee-divider">
                        <div class="spacer" style="height:0px;"></div>
                    </div>
                </div>
                <div class="bee-col bee-col-2 bee-col-w3">
                    <?php $dbselc3 = $this->db->select('pro_title,pro_title_slug,pro_price,pro_offer_price,pro_desc,pro_image')->from('tbl_product')->where('pro_id', 1686)->get()->row(); ?>
                    <div class="bee-block bee-block-1 bee-image"><img alt="Xmas Snakcs" class="bee-center bee-fixedwidth bee-fullwidthOnMobile" src="<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $dbselc3->pro_image ?>" style="max-width:334px;" /></div>
                    <div class="bee-block bee-block-3 bee-heading">
                        <h4 style="color:#171b1b;font-size:25px;font-family:Helvetica Neue, Helvetica, Arial, sans-serif;line-height:120%;text-align:left;direction:ltr;font-weight:normal;letter-spacing:normal;margin-top:0;margin-bottom:0;"><strong><?php echo substr($dbselc3->pro_title, 0, 20); ?></strong> </h4>
                    </div>
                    <div class="bee-block bee-block-4 bee-text">
                        <div class="bee-text-content" style="font-size: 14px; line-height: 150%; color: #333333; font-family: inherit;">
                            <p style="font-size: 14px; line-height: 21px; text-align: left;"><span style="font-size: 20px; line-height: 30px;">Ornament is the main key to decorating your house at Christmas.
                                     </span></p>
                        </div>
                    </div>
                    <div class="bee-block bee-block-12 bee-button"><a class="bee-button-content" href="<?php echo base_url() ?>product-details/<?php echo $dbselc3->pro_title_slug; ?>" style="font-size: 14px; line-height: 28px; font-family: inherit; background-color: #171b1b; border-radius: 4px; border-top: 1px solid #171B1B; border-right: 1px solid #171B1B; border-bottom: 1px solid #171B1B; border-left: 1px solid #171B1B; color: #ffffff; padding-top: 5px; padding-right: 40px; padding-bottom: 5px; padding-left: 40px; width: auto; max-width: 100%; display: inline-block;"><span style="font-size: 16px; line-height: 200%; word-break: break-word;">Explore Now!</span></a></div>
                    <div class="bee-block bee-block-6 bee-divider">
                        <div class="spacer" style="height:0px;"></div>
                    </div>
                    <div class="bee-block bee-block-7 bee-divider">
                        <div class="center bee-separator" style="border-top:24px solid #171B1B;width:100%;"></div>
                    </div>
                    <?php $dbselc3 = $this->db->select('pro_title,pro_title_slug,pro_price,pro_offer_price,pro_desc,pro_image')->from('tbl_product')->where('pro_id', 1724)->get()->row(); ?>
                    <div class="bee-block bee-block-1 bee-image"><img alt="Xmas Snakcs" class="bee-center bee-fixedwidth bee-fullwidthOnMobile" src="<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $dbselc3->pro_image ?>" style="max-width:334px;" /></div>
                    <div class="bee-block bee-block-3 bee-heading">
                        <h4 style="color:#171b1b;font-size:25px;font-family:Helvetica Neue, Helvetica, Arial, sans-serif;line-height:120%;text-align:left;direction:ltr;font-weight:normal;letter-spacing:normal;margin-top:0;margin-bottom:0;"><strong><?php echo substr($dbselc3->pro_title, 0, 20); ?></strong> </h4>
                    </div>
                    <div class="bee-block bee-block-4 bee-text">
                        <div class="bee-text-content" style="font-size: 14px; line-height: 150%; color: #333333; font-family: inherit;">
                            <p style="font-size: 14px; line-height: 21px; text-align: left;"><span style="font-size: 20px; line-height: 30px;">We have lost almost every state of our mind with our day-to-day life.
                                     </span></p>
                        </div>
                    </div>
                    <div class="bee-block bee-block-12 bee-button"><a class="bee-button-content" href="<?php echo base_url() ?>product-details/<?php echo $dbselc3->pro_title_slug; ?>" style="font-size: 14px; line-height: 28px; font-family: inherit; background-color: #171b1b; border-radius: 4px; border-top: 1px solid #171B1B; border-right: 1px solid #171B1B; border-bottom: 1px solid #171B1B; border-left: 1px solid #171B1B; color: #ffffff; padding-top: 5px; padding-right: 40px; padding-bottom: 5px; padding-left: 40px; width: auto; max-width: 100%; display: inline-block;"><span style="font-size: 16px; line-height: 200%; word-break: break-word;">Explore Now!</span></a></div>
                    <div class="bee-block bee-block-13 bee-divider">
                        <div class="spacer" style="height:0px;"></div>
                    </div>
                </div>
                <div class="bee-col bee-col-3 bee-col-w3">
                    <?php $dbselc3 = $this->db->select('pro_title,pro_title_slug,pro_price,pro_offer_price,pro_desc,pro_image')->from('tbl_product')->where('pro_id', 1718)->get()->row(); ?>
                    <div class="bee-block bee-block-1 bee-image"><img alt="Xmas Snakcs" class="bee-center bee-fixedwidth bee-fullwidthOnMobile" src="<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $dbselc3->pro_image ?>" style="max-width:334px;" /></div>
                    <div class="bee-block bee-block-3 bee-heading">
                        <h4 style="color:#171b1b;font-size:25px;font-family:Helvetica Neue, Helvetica, Arial, sans-serif;line-height:120%;text-align:left;direction:ltr;font-weight:normal;letter-spacing:normal;margin-top:0;margin-bottom:0;"><strong><?php echo substr($dbselc3->pro_title, 0, 20); ?></strong> </h4>
                    </div>
                    <div class="bee-block bee-block-4 bee-text">
                        <div class="bee-text-content" style="font-size: 14px; line-height: 150%; color: #333333; font-family: inherit;">
                            <p style="font-size: 14px; line-height: 21px; text-align: left;"><span style="font-size: 20px; line-height: 30px;">Christmas is nothing but all about tasty & delicious food.
                                     </span></p>
                        </div>
                    </div>
                    <div class="bee-block bee-block-12 bee-button"><a class="bee-button-content" href="<?php echo base_url() ?>product-details/<?php echo $dbselc3->pro_title_slug; ?>" style="font-size: 14px; line-height: 28px; font-family: inherit; background-color: #171b1b; border-radius: 4px; border-top: 1px solid #171B1B; border-right: 1px solid #171B1B; border-bottom: 1px solid #171B1B; border-left: 1px solid #171B1B; color: #ffffff; padding-top: 5px; padding-right: 40px; padding-bottom: 5px; padding-left: 40px; width: auto; max-width: 100%; display: inline-block;"><span style="font-size: 16px; line-height: 200%; word-break: break-word;">Explore Now!</span></a></div>
                    <div class="bee-block bee-block-6 bee-divider">
                        <div class="spacer" style="height:0px;"></div>
                    </div>
                    <div class="bee-block bee-block-7 bee-divider">
                        <div class="center bee-separator" style="border-top:24px solid #171B1B;width:100%;"></div>
                    </div>
                    <?php $dbselc3 = $this->db->select('pro_title,pro_title_slug,pro_price,pro_offer_price,pro_desc,pro_image')->from('tbl_product')->where('pro_id', 1693)->get()->row(); ?>
                    <div class="bee-block bee-block-1 bee-image"><img alt="Xmas Snakcs" class="bee-center bee-fixedwidth bee-fullwidthOnMobile" src="<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $dbselc3->pro_image ?>" style="max-width:334px;" /></div>
                    <div class="bee-block bee-block-3 bee-heading">
                        <h4 style="color:#171b1b;font-size:25px;font-family:Helvetica Neue, Helvetica, Arial, sans-serif;line-height:120%;text-align:left;direction:ltr;font-weight:normal;letter-spacing:normal;margin-top:0;margin-bottom:0;"><strong><?php echo substr($dbselc3->pro_title, 0, 20); ?></strong> </h4>
                    </div>
                    <div class="bee-block bee-block-4 bee-text">
                        <div class="bee-text-content" style="font-size: 14px; line-height: 150%; color: #333333; font-family: inherit;">
                            <p style="font-size: 14px; line-height: 21px; text-align: left;"><span style="font-size: 20px; line-height: 30px;">These Christmas Alphabet Knitting socks can be used for decorating your house.
                                     </span></p>
                        </div>
                    </div>
                    <div class="bee-block bee-block-12 bee-button"><a class="bee-button-content" href="<?php echo base_url() ?>product-details/<?php echo $dbselc3->pro_title_slug; ?>" style="font-size: 14px; line-height: 28px; font-family: inherit; background-color: #171b1b; border-radius: 4px; border-top: 1px solid #171B1B; border-right: 1px solid #171B1B; border-bottom: 1px solid #171B1B; border-left: 1px solid #171B1B; color: #ffffff; padding-top: 5px; padding-right: 40px; padding-bottom: 5px; padding-left: 40px; width: auto; max-width: 100%; display: inline-block;"><span style="font-size: 16px; line-height: 200%; word-break: break-word;">Explore Now!</span></a></div>
                    <div class="bee-block bee-block-13 bee-divider">
                        <div class="spacer" style="height:0px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bee-row bee-row-12">
            <div class="bee-row-content">
                <div class="bee-col bee-col-1 bee-col-w12">
                    <div class="bee-block bee-block-1 bee-divider">
                        <div class="spacer" style="height:20px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bee-row bee-row-15">
            <div class="bee-row-content">
                <div class="bee-col bee-col-3 bee-col-w3">
                    <?php $dbselc5 = $this->db->select('pro_title,pro_title_slug,pro_price,pro_offer_price,pro_desc,pro_image')->from('tbl_product')->where('pro_id', 1698)->get()->row(); ?>
                    <div class="bee-block bee-block-1 bee-divider">
                        <div class="spacer" style="height:5px;"></div>
                    </div>
                    <div class="bee-block bee-block-2 bee-image"><img alt="Chocolate in Black Box" class="bee-center bee-fixedwidth bee-fullwidthOnMobile" src="<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $dbselc5->pro_image ?>" style="max-width:292px;" /></div>
                    <div class="bee-block bee-block-3 bee-text">
                        <div class="bee-text-content" style="font-size: 14px; line-height: 150%; color: #333333; font-family: inherit;">
                            <p style="font-size: 14px; line-height: 21px; text-align: center;"><span style="font-size: 22px; line-height: 33px;"><?php echo substr($dbselc5->pro_title, 0, 50); ?></span></p>
                        </div>
                    </div>
                    <div class="bee-block bee-block-4 bee-text">
                        <div class="item-price">
                            <?php if (!empty($dbselc5->pro_offer_price)) { ?>
                                <div class="price-box">
                                    <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"><?php echo currencyConverterFunction($dbselc5->pro_offer_price); ?> </span> </p>
                                    <p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price"><?php echo currencyConverterFunction($dbselc5->pro_price); ?> </span> </p>
                                </div>
                            <?php } else { ?>
                                <div class="price-box">
                                    <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"> <?php echo currencyConverterFunction($dbselc5->pro_price); ?> </span> </p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="bee-block bee-block-5 bee-button"><a class="bee-button-content" href="<?php echo base_url() ?>product-details/<?php echo $dbselc5->pro_title_slug; ?>" style="font-size: 14px; line-height: 28px; font-family: inherit; background-color: #171b1b; border-radius: 4px; border-top: 1px solid #171B1B; border-right: 1px solid #171B1B; border-bottom: 1px solid #171B1B; border-left: 1px solid #171B1B; color: #ffffff; padding-top: 5px; padding-right: 40px; padding-bottom: 5px; padding-left: 40px; width: auto; max-width: 100%; display: inline-block;"><span style="font-size: 16px; line-height: 200%; word-break: break-word;">Explore Now!</span></a></div>
                    <div class="bee-block bee-block-6 bee-divider">
                        <div class="spacer" style="height:10px;"></div>
                    </div>
                </div>
                <div class="bee-col bee-col-4 bee-col-w3">
                    <?php $dbselc4 = $this->db->select('pro_title,pro_title_slug,pro_price,pro_offer_price,pro_desc,pro_image')->from('tbl_product')->where('pro_id', 1694)->get()->row(); ?>
                    <div class="bee-block bee-block-1 bee-divider">
                        <div class="spacer" style="height:15px;"></div>
                    </div>
                    <div class="bee-block bee-block-2 bee-image"><img alt="Chocolate in White Box" class="bee-center bee-fixedwidth bee-fullwidthOnMobile" src="<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $dbselc4->pro_image ?>" style="max-width:292px;" /></div>
                    <div class="bee-block bee-block-3 bee-text">
                        <div class="bee-text-content" style="font-size: 14px; line-height: 150%; color: #e9e9e9; font-family: inherit;">
                            <p style="font-size: 14px; line-height: 21px; text-align: center;"><span style="font-size: 20px; line-height: 30px;"><?php echo substr($dbselc4->pro_title, 0, 50); ?></span></p>
                        </div>
                    </div>
                    <div class="bee-block bee-block-4 bee-text">
                        <div class="item-price">
                            <?php if (!empty($dbselc4->pro_offer_price)) { ?>
                                <div class="price-box">
                                    <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"><?php echo currencyConverterFunction($dbselc4->pro_offer_price); ?> </span> </p>
                                    <p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price"><?php echo currencyConverterFunction($dbselc4->pro_price); ?> </span> </p>
                                </div>
                            <?php } else { ?>
                                <div class="price-box">
                                    <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"> <?php echo currencyConverterFunction($dbselc4->pro_price); ?> </span> </p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="bee-block bee-block-5 bee-button"><a class="bee-button-content" href="<?php echo base_url() ?>product-details/<?php echo $dbselc4->pro_title_slug; ?>" style="font-size: 14px; line-height: 28px; font-family: inherit; background-color: #c92727; border-radius: 4px; border-top: 1px solid #C92727; border-right: 1px solid #C92727; border-bottom: 1px solid #C92727; border-left: 1px solid #C92727; color: #ffffff; padding-top: 5px; padding-right: 20px; padding-bottom: 5px; padding-left: 20px; width: auto; max-width: 100%; display: inline-block;"><span style="font-size: 16px; line-height: 200%; word-break: break-word;">Explore Now! </span></a></div>
                    <div class="bee-block bee-block-6 bee-divider">
                        <div class="spacer" style="height:10px;"></div>
                    </div>
                </div>
                <div class="bee-col bee-col-3 bee-col-w3">
                    <?php $dbselc5 = $this->db->select('pro_title,pro_title_slug,pro_price,pro_offer_price,pro_desc,pro_image')->from('tbl_product')->where('pro_id', 1686)->get()->row(); ?>
                    <div class="bee-block bee-block-1 bee-divider">
                        <div class="spacer" style="height:5px;"></div>
                    </div>
                    <div class="bee-block bee-block-2 bee-image"><img alt="Chocolate in Black Box" class="bee-center bee-fixedwidth bee-fullwidthOnMobile" src="<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $dbselc5->pro_image ?>" style="max-width:292px;" /></div>
                    <div class="bee-block bee-block-3 bee-text">
                        <div class="bee-text-content" style="font-size: 14px; line-height: 150%; color: #333333; font-family: inherit;">
                            <p style="font-size: 14px; line-height: 21px; text-align: center;"><span style="font-size: 22px; line-height: 33px;"><?php echo substr($dbselc5->pro_title, 0, 50); ?></span></p>
                        </div>
                    </div>
                    <div class="bee-block bee-block-4 bee-text">
                        <div class="item-price">
                            <?php if (!empty($dbselc5->pro_offer_price)) { ?>
                                <div class="price-box">
                                    <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"><?php echo currencyConverterFunction($dbselc5->pro_offer_price); ?> </span> </p>
                                    <p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price"><?php echo currencyConverterFunction($dbselc5->pro_price); ?> </span> </p>
                                </div>
                            <?php } else { ?>
                                <div class="price-box">
                                    <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"> <?php echo currencyConverterFunction($dbselc5->pro_price); ?> </span> </p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="bee-block bee-block-5 bee-button"><a class="bee-button-content" href="<?php echo base_url() ?>product-details/<?php echo $dbselc5->pro_title_slug; ?>" style="font-size: 14px; line-height: 28px; font-family: inherit; background-color: #171b1b; border-radius: 4px; border-top: 1px solid #171B1B; border-right: 1px solid #171B1B; border-bottom: 1px solid #171B1B; border-left: 1px solid #171B1B; color: #ffffff; padding-top: 5px; padding-right: 40px; padding-bottom: 5px; padding-left: 40px; width: auto; max-width: 100%; display: inline-block;"><span style="font-size: 16px; line-height: 200%; word-break: break-word;">Explore Now!</span></a></div>
                    <div class="bee-block bee-block-6 bee-divider">
                        <div class="spacer" style="height:10px;"></div>
                    </div>
                </div>
                <div class="bee-col bee-col-4 bee-col-w3">
                    <?php $dbselc4 = $this->db->select('pro_title,pro_title_slug,pro_price,pro_offer_price,pro_desc,pro_image')->from('tbl_product')->where('pro_id', 1680)->get()->row(); ?>
                    <div class="bee-block bee-block-1 bee-divider">
                        <div class="spacer" style="height:15px;"></div>
                    </div>
                    <div class="bee-block bee-block-2 bee-image"><img alt="Chocolate in White Box" class="bee-center bee-fixedwidth bee-fullwidthOnMobile" src="<?php echo 'https://www.seller.grabgreatdeals.com/' . 'uploads/large/' . $dbselc4->pro_image ?>" style="max-width:292px;" /></div>
                    <div class="bee-block bee-block-3 bee-text">
                        <div class="bee-text-content" style="font-size: 14px; line-height: 150%; color: #e9e9e9; font-family: inherit;">
                            <p style="font-size: 14px; line-height: 21px; text-align: center;"><span style="font-size: 20px; line-height: 30px;"><?php echo substr($dbselc4->pro_title, 0, 50); ?></span></p>
                        </div>
                    </div>
                    <div class="bee-block bee-block-4 bee-text">
                        <div class="item-price">
                            <?php if (!empty($dbselc4->pro_offer_price)) { ?>
                                <div class="price-box">
                                    <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"><?php echo currencyConverterFunction($dbselc4->pro_offer_price); ?> </span> </p>
                                    <p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price"><?php echo currencyConverterFunction($dbselc4->pro_price); ?> </span> </p>
                                </div>
                            <?php } else { ?>
                                <div class="price-box">
                                    <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"> <?php echo currencyConverterFunction($dbselc4->pro_price); ?> </span> </p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="bee-block bee-block-5 bee-button"><a class="bee-button-content" href="<?php echo base_url() ?>product-details/<?php echo $dbselc4->pro_title_slug; ?>" style="font-size: 14px; line-height: 28px; font-family: inherit; background-color: #c92727; border-radius: 4px; border-top: 1px solid #C92727; border-right: 1px solid #C92727; border-bottom: 1px solid #C92727; border-left: 1px solid #C92727; color: #ffffff; padding-top: 5px; padding-right: 20px; padding-bottom: 5px; padding-left: 20px; width: auto; max-width: 100%; display: inline-block;"><span style="font-size: 16px; line-height: 200%; word-break: break-word;">Explore Now! </span></a></div>
                    <div class="bee-block bee-block-6 bee-divider">
                        <div class="spacer" style="height:10px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bee-row bee-row-16">
            <div class="bee-row-content">
                <div class="bee-col bee-col-1 bee-col-w12">
                    <div class="bee-block bee-block-1 bee-divider">
                        <div class="spacer" style="height:60px;"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>