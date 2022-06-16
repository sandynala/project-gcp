<?php ! defined( 'ABSPATH' ) && exit(); ?><script type="text/javascript">
    document.body.classList.add('folded');
    document.getElementById('screen-meta').remove();
    window.addEventListener('load', () => document.getElementById('wpfooter').remove(), false);

    APP_CONFIG = <?php echo json_encode($config); ?>;
</script>
<totalsurvey-root>
    <style>
        #adminmenumain {
            position: absolute;
            height: 100%;
            overflow-y: auto;
        }

        #adminmenumain:hover, #adminmenumain:focus {
            width: 300px;
        }

        @keyframes loading {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        .totalsurvey-loading {
            position: absolute;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.9);
            z-index: 10;
            height: 100%;
            width: 100%;
            font-size: 24px;
        }

        .totalsurvey-loading-spinner {
            font-size: 5px;
            margin: 50px auto;
            text-indent: -9999em;
            width: 11em;
            height: 11em;
            border-radius: 50%;
            background: #cccccc;
            background: -moz-linear-gradient(left, #cccccc 10%, rgba(255, 255, 255, 0) 42%);
            background: -webkit-linear-gradient(left, #cccccc 10%, rgba(255, 255, 255, 0) 42%);
            background: -o-linear-gradient(left, #cccccc 10%, rgba(255, 255, 255, 0) 42%);
            background: -ms-linear-gradient(left, #cccccc 10%, rgba(255, 255, 255, 0) 42%);
            background: linear-gradient(to right, #cccccc 10%, rgba(255, 255, 255, 0) 42%);
            position: relative;
            animation: loading 1.4s infinite linear;
            transform: translateZ(0);
        }

        .totalsurvey-loading-spinner:before {
            width: 50%;
            height: 50%;
            background: #cccccc;
            border-radius: 100% 0 0 0;
            position: absolute;
            top: 0;
            left: 0;
            content: '';
        }

        .totalsurvey-loading-spinner:after {
            background: white;
            width: 75%;
            height: 75%;
            border-radius: 50%;
            content: '';
            margin: auto;
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
        }

    </style>
    <div class="totalsurvey-loading">
        <div class="totalsurvey-loading-spinner"></div>
    </div>
</totalsurvey-root>
