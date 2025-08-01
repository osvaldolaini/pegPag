<div>
    <style>
        /*!
        * Load Awesome v1.1.0 (http://github.danielcardoso.net/load-awesome/)
        * Copyright 2015 Daniel Cardoso <@DanielCardoso>
        * Licensed under MIT
        */
        .la-timer,
        .la-timer>div {
            position: relative;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .la-timer {
            display: block;
            font-size: 0;
            color: #fff;
        }

        .la-timer.la-dark {
            color: #333;
        }

        .la-timer>div {
            display: inline-block;
            float: none;
            background-color: currentColor;
            border: 0 solid currentColor;
        }

        .la-timer {
            width: 32px;
            height: 32px;
        }

        .la-timer>div {
            width: 32px;
            height: 32px;
            background: transparent;
            border-width: 2px;
            border-radius: 100%;
        }

        .la-timer>div:before,
        .la-timer>div:after {
            position: absolute;
            top: 14px;
            left: 14px;
            display: block;
            width: 2px;
            margin-top: -1px;
            margin-left: -1px;
            content: "";
            background: currentColor;
            border-radius: 2px;
            -webkit-transform-origin: 1px 1px 0;
            -moz-transform-origin: 1px 1px 0;
            -ms-transform-origin: 1px 1px 0;
            -o-transform-origin: 1px 1px 0;
            transform-origin: 1px 1px 0;
            -webkit-animation: timer-loader 1250ms infinite linear;
            -moz-animation: timer-loader 1250ms infinite linear;
            -o-animation: timer-loader 1250ms infinite linear;
            animation: timer-loader 1250ms infinite linear;
            -webkit-animation-delay: -625ms;
            -moz-animation-delay: -625ms;
            -o-animation-delay: -625ms;
            animation-delay: -625ms;
        }

        .la-timer>div:before {
            height: 12px;
        }

        .la-timer>div:after {
            height: 8px;
            -webkit-animation-duration: 15s;
            -moz-animation-duration: 15s;
            -o-animation-duration: 15s;
            animation-duration: 15s;
            -webkit-animation-delay: -7.5s;
            -moz-animation-delay: -7.5s;
            -o-animation-delay: -7.5s;
            animation-delay: -7.5s;
        }

        .la-timer.la-sm {
            width: 16px;
            height: 16px;
        }

        .la-timer.la-sm>div {
            width: 16px;
            height: 16px;
            border-width: 1px;
        }

        .la-timer.la-sm>div:before,
        .la-timer.la-sm>div:after {
            top: 7px;
            left: 7px;
            width: 1px;
            margin-top: -.5px;
            margin-left: -.5px;
            border-radius: 1px;
            -webkit-transform-origin: .5px .5px 0;
            -moz-transform-origin: .5px .5px 0;
            -ms-transform-origin: .5px .5px 0;
            -o-transform-origin: .5px .5px 0;
            transform-origin: .5px .5px 0;
        }

        .la-timer.la-sm>div:before {
            height: 6px;
        }

        .la-timer.la-sm>div:after {
            height: 4px;
        }

        .la-timer.la-2x {
            width: 64px;
            height: 64px;
        }

        .la-timer.la-2x>div {
            width: 64px;
            height: 64px;
            border-width: 4px;
        }

        .la-timer.la-2x>div:before,
        .la-timer.la-2x>div:after {
            top: 28px;
            left: 28px;
            width: 4px;
            margin-top: -2px;
            margin-left: -2px;
            border-radius: 4px;
            -webkit-transform-origin: 2px 2px 0;
            -moz-transform-origin: 2px 2px 0;
            -ms-transform-origin: 2px 2px 0;
            -o-transform-origin: 2px 2px 0;
            transform-origin: 2px 2px 0;
        }

        .la-timer.la-2x>div:before {
            height: 24px;
        }

        .la-timer.la-2x>div:after {
            height: 16px;
        }

        .la-timer.la-3x {
            width: 96px;
            height: 96px;
        }

        .la-timer.la-3x>div {
            width: 96px;
            height: 96px;
            border-width: 6px;
        }

        .la-timer.la-3x>div:before,
        .la-timer.la-3x>div:after {
            top: 42px;
            left: 42px;
            width: 6px;
            margin-top: -3px;
            margin-left: -3px;
            border-radius: 6px;
            -webkit-transform-origin: 3px 3px 0;
            -moz-transform-origin: 3px 3px 0;
            -ms-transform-origin: 3px 3px 0;
            -o-transform-origin: 3px 3px 0;
            transform-origin: 3px 3px 0;
        }

        .la-timer.la-3x>div:before {
            height: 36px;
        }

        .la-timer.la-3x>div:after {
            height: 24px;
        }

        /*
        * Animation
        */
        @-webkit-keyframes timer-loader {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @-moz-keyframes timer-loader {
            0% {
                -moz-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -moz-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @-o-keyframes timer-loader {
            0% {
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes timer-loader {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        /*!
        * Load Awesome v1.1.0 (http://github.danielcardoso.net/load-awesome/)
        * Copyright 2015 Daniel Cardoso <@DanielCardoso>
        * Licensed under MIT
        */
        .la-square-jelly-box,
        .la-square-jelly-box>div {
            position: relative;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .la-square-jelly-box {
            display: block;
            font-size: 0;
            color: #fff;
        }

        .la-square-jelly-box.la-dark {
            color: #333;
        }

        .la-square-jelly-box>div {
            display: inline-block;
            float: none;
            background-color: currentColor;
            border: 0 solid currentColor;
        }

        .la-square-jelly-box {
            width: 32px;
            height: 32px;
        }

        .la-square-jelly-box>div:nth-child(1),
        .la-square-jelly-box>div:nth-child(2) {
            position: absolute;
            left: 0;
            width: 100%;
        }

        .la-square-jelly-box>div:nth-child(1) {
            top: -25%;
            z-index: 1;
            height: 100%;
            border-radius: 10%;
            -webkit-animation: square-jelly-box-animate .6s -.1s linear infinite;
            -moz-animation: square-jelly-box-animate .6s -.1s linear infinite;
            -o-animation: square-jelly-box-animate .6s -.1s linear infinite;
            animation: square-jelly-box-animate .6s -.1s linear infinite;
        }

        .la-square-jelly-box>div:nth-child(2) {
            bottom: -9%;
            height: 10%;
            background: #000;
            border-radius: 50%;
            opacity: .2;
            -webkit-animation: square-jelly-box-shadow .6s -.1s linear infinite;
            -moz-animation: square-jelly-box-shadow .6s -.1s linear infinite;
            -o-animation: square-jelly-box-shadow .6s -.1s linear infinite;
            animation: square-jelly-box-shadow .6s -.1s linear infinite;
        }

        .la-square-jelly-box.la-sm {
            width: 16px;
            height: 16px;
        }

        .la-square-jelly-box.la-2x {
            width: 64px;
            height: 64px;
        }

        .la-square-jelly-box.la-3x {
            width: 96px;
            height: 96px;
        }

        /*
        * Animations
        */
        @-webkit-keyframes square-jelly-box-animate {
            17% {
                border-bottom-right-radius: 10%;
            }

            25% {
                -webkit-transform: translateY(25%) rotate(22.5deg);
                transform: translateY(25%) rotate(22.5deg);
            }

            50% {
                border-bottom-right-radius: 100%;
                -webkit-transform: translateY(50%) scale(1, .9) rotate(45deg);
                transform: translateY(50%) scale(1, .9) rotate(45deg);
            }

            75% {
                -webkit-transform: translateY(25%) rotate(67.5deg);
                transform: translateY(25%) rotate(67.5deg);
            }

            100% {
                -webkit-transform: translateY(0) rotate(90deg);
                transform: translateY(0) rotate(90deg);
            }
        }

        @-moz-keyframes square-jelly-box-animate {
            17% {
                border-bottom-right-radius: 10%;
            }

            25% {
                -moz-transform: translateY(25%) rotate(22.5deg);
                transform: translateY(25%) rotate(22.5deg);
            }

            50% {
                border-bottom-right-radius: 100%;
                -moz-transform: translateY(50%) scale(1, .9) rotate(45deg);
                transform: translateY(50%) scale(1, .9) rotate(45deg);
            }

            75% {
                -moz-transform: translateY(25%) rotate(67.5deg);
                transform: translateY(25%) rotate(67.5deg);
            }

            100% {
                -moz-transform: translateY(0) rotate(90deg);
                transform: translateY(0) rotate(90deg);
            }
        }

        @-o-keyframes square-jelly-box-animate {
            17% {
                border-bottom-right-radius: 10%;
            }

            25% {
                -o-transform: translateY(25%) rotate(22.5deg);
                transform: translateY(25%) rotate(22.5deg);
            }

            50% {
                border-bottom-right-radius: 100%;
                -o-transform: translateY(50%) scale(1, .9) rotate(45deg);
                transform: translateY(50%) scale(1, .9) rotate(45deg);
            }

            75% {
                -o-transform: translateY(25%) rotate(67.5deg);
                transform: translateY(25%) rotate(67.5deg);
            }

            100% {
                -o-transform: translateY(0) rotate(90deg);
                transform: translateY(0) rotate(90deg);
            }
        }

        @keyframes square-jelly-box-animate {
            17% {
                border-bottom-right-radius: 10%;
            }

            25% {
                -webkit-transform: translateY(25%) rotate(22.5deg);
                -moz-transform: translateY(25%) rotate(22.5deg);
                -o-transform: translateY(25%) rotate(22.5deg);
                transform: translateY(25%) rotate(22.5deg);
            }

            50% {
                border-bottom-right-radius: 100%;
                -webkit-transform: translateY(50%) scale(1, .9) rotate(45deg);
                -moz-transform: translateY(50%) scale(1, .9) rotate(45deg);
                -o-transform: translateY(50%) scale(1, .9) rotate(45deg);
                transform: translateY(50%) scale(1, .9) rotate(45deg);
            }

            75% {
                -webkit-transform: translateY(25%) rotate(67.5deg);
                -moz-transform: translateY(25%) rotate(67.5deg);
                -o-transform: translateY(25%) rotate(67.5deg);
                transform: translateY(25%) rotate(67.5deg);
            }

            100% {
                -webkit-transform: translateY(0) rotate(90deg);
                -moz-transform: translateY(0) rotate(90deg);
                -o-transform: translateY(0) rotate(90deg);
                transform: translateY(0) rotate(90deg);
            }
        }

        @-webkit-keyframes square-jelly-box-shadow {
            50% {
                -webkit-transform: scale(1.25, 1);
                transform: scale(1.25, 1);
            }
        }

        @-moz-keyframes square-jelly-box-shadow {
            50% {
                -moz-transform: scale(1.25, 1);
                transform: scale(1.25, 1);
            }
        }

        @-o-keyframes square-jelly-box-shadow {
            50% {
                -o-transform: scale(1.25, 1);
                transform: scale(1.25, 1);
            }
        }

        @keyframes square-jelly-box-shadow {
            50% {
                -webkit-transform: scale(1.25, 1);
                -moz-transform: scale(1.25, 1);
                -o-transform: scale(1.25, 1);
                transform: scale(1.25, 1);
            }
        }
    </style>
    <div class="fixed w-full h-screen top-0 right-0 z-50 items-center justify-items-center
    bg-blue-900 bg-opacity-50 backdrop-brightness-50 backdrop-blur-sm "
        wire:loading>
        <div
            class="relative flex flex-col items-center max-w-lg gap-4 p-6 rounded-md top-40
        shadow-md sm:py-8 sm:px-12 bg-blue-900 text-gray-100 mx-auto">
            <div style="color: #64d6e2" class="la-timer la-3x">
                <div></div>
            </div>
            <h2 class="text-2xl font-semibold leadi tracki">Carregando<span
                    class="loading loading-dots loading-xs"></span>
            </h2>
        </div>
    </div>
</div>
