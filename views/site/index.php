<?php

/** @var yii\web\View $this */

$this->title = 'Приветствие';

use app\assets\greeting\{AnimateAsset, GreetingAsset};

AnimateAsset::register($this);
GreetingAsset::register($this);

?>

<div class="wrapper">
    <header class="w-full absolute my-8 left-0 top-0">
        <div class="mx-auto container">
            <div class="flex items-end justify-end w-full">
                <div class="text-gray-700 font-normal leading-none text-sm" id="time">00:00</div>
            </div>
        </div>
    </header>


    <main>
        <section class="h-screen home-page">
          <div class="items-center justify-center flex flex-col container gap-20 h-full lg:flex-row m-auto w-full">
            <div class="items-center justify-center flex flex-col">
              <div class="flex flex-col lg:flex-row items-end">
                <h1 id="mainTitle" class="w-full font-medium lg:leading-none lg:text-[15rem] sm:text-9xl text-8xl text-center text-gray-800">
                  ЭФКО
                </h1>
                <div id="yellowSquare" class="h-5 w-5 bg-amber-300 lg:h-10 lg:w-10"></div>
              </div>
              <p id="subtitle" class="text-gray-700 text-2xl font-normal lg:text-5xl text-left">Цифровые решения</p>
              <div id="projectInfo" class="flex container items-end justify-between mt-10 mx-auto">
                <span class="text-gray-700 text-2xl lg:text-3xl">
                  Меня зовут <b>[ваше_имя]</b> <br> Это мой первый проект, на стеке HTML, CSS, JS, PHP, SQL
                </span>
              </div>

            </div>

            <div class="w-full border-l-2 px-4">
              <ul class="flex flex-col gap-12 px-8 relative">
                <li>
                  <div class="items-center justify-center -left-11 absolute bg-white border-2 h-10 hidden lg:flex rounded w-10">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#374151" d="M320 464c8.8 0 16-7.2 16-16V160H256c-17.7 0-32-14.3-32-32V48H64c-8.8 0-16 7.2-16 16V448c0 8.8 7.2 16 16 16H320zM0 64C0 28.7 28.7 0 64 0H229.5c17 0 33.3 6.7 45.3 18.7l90.5 90.5c12 12 18.7 28.3 18.7 45.3V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V64z"/></svg>
                  </div>
                  <div id="listItem1">
                    <a href="https://edu-efko.ru/" target="_blank" class="font-semibold text-gray-700 text-xl">Сайт курса</a>
                    <p class="font-semibold text-gray-400 text-sm">Порекомендуй нас друзьям</p>
                  </div>
                </li>

                <li id="listItem2">
                  <div class="items-center justify-center -left-11 absolute bg-white border-2 h-10 hidden lg:flex rounded w-10">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#374151" d="M248 8C111 8 0 119 0 256S111 504 248 504 496 393 496 256 385 8 248 8zM363 176.7c-3.7 39.2-19.9 134.4-28.1 178.3-3.5 18.6-10.3 24.8-16.9 25.4-14.4 1.3-25.3-9.5-39.3-18.7-21.8-14.3-34.2-23.2-55.3-37.2-24.5-16.1-8.6-25 5.3-39.5 3.7-3.8 67.1-61.5 68.3-66.7 .2-.7 .3-3.1-1.2-4.4s-3.6-.8-5.1-.5q-3.3 .7-104.6 69.1-14.8 10.2-26.9 9.9c-8.9-.2-25.9-5-38.6-9.1-15.5-5-27.9-7.7-26.8-16.3q.8-6.7 18.5-13.7 108.4-47.2 144.6-62.3c68.9-28.6 83.2-33.6 92.5-33.8 2.1 0 6.6 .5 9.6 2.9a10.5 10.5 0 0 1 3.5 6.7A43.8 43.8 0 0 1 363 176.7z"/></svg>
                  </div>
                  <div>
                    <a href="https://t.me/efko_digital" target="_blank" class="font-semibold text-gray-700 text-xl">Telegram</a>
                    <p class="font-semibold text-gray-400 text-sm">Подпишись на группу и будь в курсе всех новостей</p>
                  </div>
                </li>

                <li id="listItem3">
                  <div class="items-center justify-center -left-11 absolute bg-white border-2 h-10 hidden lg:flex rounded w-10">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#374151" d="M165.9 397.4c0 2-2.3 3.6-5.2 3.6-3.3 .3-5.6-1.3-5.6-3.6 0-2 2.3-3.6 5.2-3.6 3-.3 5.6 1.3 5.6 3.6zm-31.1-4.5c-.7 2 1.3 4.3 4.3 4.9 2.6 1 5.6 0 6.2-2s-1.3-4.3-4.3-5.2c-2.6-.7-5.5 .3-6.2 2.3zm44.2-1.7c-2.9 .7-4.9 2.6-4.6 4.9 .3 2 2.9 3.3 5.9 2.6 2.9-.7 4.9-2.6 4.6-4.6-.3-1.9-3-3.2-5.9-2.9zM244.8 8C106.1 8 0 113.3 0 252c0 110.9 69.8 205.8 169.5 239.2 12.8 2.3 17.3-5.6 17.3-12.1 0-6.2-.3-40.4-.3-61.4 0 0-70 15-84.7-29.8 0 0-11.4-29.1-27.8-36.6 0 0-22.9-15.7 1.6-15.4 0 0 24.9 2 38.6 25.8 21.9 38.6 58.6 27.5 72.9 20.9 2.3-16 8.8-27.1 16-33.7-55.9-6.2-112.3-14.3-112.3-110.5 0-27.5 7.6-41.3 23.6-58.9-2.6-6.5-11.1-33.3 2.6-67.9 20.9-6.5 69 27 69 27 20-5.6 41.5-8.5 62.8-8.5s42.8 2.9 62.8 8.5c0 0 48.1-33.6 69-27 13.7 34.7 5.2 61.4 2.6 67.9 16 17.7 25.8 31.5 25.8 58.9 0 96.5-58.9 104.2-114.8 110.5 9.2 7.9 17 22.9 17 46.4 0 33.7-.3 75.4-.3 83.6 0 6.5 4.6 14.4 17.3 12.1C428.2 457.8 496 362.9 496 252 496 113.3 383.5 8 244.8 8zM97.2 352.9c-1.3 1-1 3.3 .7 5.2 1.6 1.6 3.9 2.3 5.2 1 1.3-1 1-3.3-.7-5.2-1.6-1.6-3.9-2.3-5.2-1zm-10.8-8.1c-.7 1.3 .3 2.9 2.3 3.9 1.6 1 3.6 .7 4.3-.7 .7-1.3-.3-2.9-2.3-3.9-2-.6-3.6-.3-4.3 .7zm32.4 35.6c-1.6 1.3-1 4.3 1.3 6.2 2.3 2.3 5.2 2.6 6.5 1 1.3-1.3 .7-4.3-1.3-6.2-2.2-2.3-5.2-2.6-6.5-1zm-11.4-14.7c-1.6 1-1.6 3.6 0 5.9 1.6 2.3 4.3 3.3 5.6 2.3 1.6-1.3 1.6-3.9 0-6.2-1.4-2.3-4-3.3-5.6-2z"/></svg>
                  </div>
                  <div>
                    <a target="_blank" class="font-semibold text-gray-700 text-xl">GitHub</a>
                    <p class="font-semibold text-gray-400 text-sm">Поделись своим проектом с другими</p>
                  </div>
                </li>

                <li id="listItem4">
                  <div class="items-center justify-center -left-11 absolute bg-white border-2 h-10 hidden lg:flex rounded w-10">
                    <svg class="h-5 w-5" fill="#3d3d3d" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64zM96 64H288c17.7 0 32 14.3 32 32v32c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V96c0-17.7 14.3-32 32-32zm32 160a32 32 0 1 1 -64 0 32 32 0 1 1 64 0zM96 352a32 32 0 1 1 0-64 32 32 0 1 1 0 64zM64 416c0-17.7 14.3-32 32-32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H96c-17.7 0-32-14.3-32-32zM192 256a32 32 0 1 1 0-64 32 32 0 1 1 0 64zm32 64a32 32 0 1 1 -64 0 32 32 0 1 1 64 0zm64-64a32 32 0 1 1 0-64 32 32 0 1 1 0 64zm32 64a32 32 0 1 1 -64 0 32 32 0 1 1 64 0zM288 448a32 32 0 1 1 0-64 32 32 0 1 1 0 64z"/></svg>
                  </div>
                  <div>
                    <a href="/calculator" target="_blank" class="font-semibold text-gray-700 text-xl">Калькулятор</a>
                    <p class="font-semibold text-gray-400 text-sm">Рассчитать стоимость доставки</p>
                  </div>
                </li>

                <li id="listItem5">
                  <div class="items-center justify-center -left-11 absolute bg-white border-2 h-10 hidden lg:flex rounded w-10 bottom-0">
                    <svg class="h-7 w-7" fill="#3d3d3d" viewBox="0 0 32.00 32.00" xmlns="http://www.w3.org/2000/svg"><path d="M16 0c-8.823 0-16 7.177-16 16s7.177 16 16 16c8.823 0 16-7.177 16-16s-7.177-16-16-16zM16 1.527c7.995 0 14.473 6.479 14.473 14.473s-6.479 14.473-14.473 14.473c-7.995 0-14.473-6.479-14.473-14.473s6.479-14.473 14.473-14.473zM11.161 7.823c-0.188-0.005-0.375 0-0.568 0.005-1.307 0.079-2.093 0.693-2.312 1.964-0.151 0.891-0.125 1.796-0.188 2.692-0.020 0.464-0.067 0.928-0.156 1.38-0.177 0.813-0.525 1.068-1.353 1.109-0.111 0.011-0.22 0.032-0.324 0.057v1.948c1.5 0.073 1.704 0.605 1.823 2.172 0.048 0.573-0.015 1.147 0.021 1.719 0.027 0.543 0.099 1.079 0.208 1.6 0.344 1.432 1.745 1.911 3.433 1.624v-1.713c-0.272 0-0.511 0.005-0.74 0-0.579-0.016-0.792-0.161-0.844-0.713-0.079-0.713-0.057-1.437-0.099-2.156-0.089-1.339-0.235-2.651-1.541-3.5 0.672-0.495 1.161-1.084 1.312-1.865 0.109-0.547 0.177-1.099 0.219-1.651s-0.025-1.12 0.021-1.667c0.077-0.885 0.135-1.249 1.197-1.213 0.161 0 0.317-0.021 0.495-0.036v-1.745c-0.213 0-0.411-0.005-0.604-0.011zM21.287 7.839c-0.365-0.011-0.729 0.016-1.089 0.079v1.697c0.329 0 0.584 0 0.833 0.005 0.439 0.005 0.772 0.177 0.813 0.661 0.041 0.443 0.041 0.891 0.083 1.339 0.089 0.896 0.136 1.796 0.292 2.677 0.136 0.724 0.636 1.265 1.255 1.713-1.088 0.729-1.411 1.776-1.463 2.953-0.032 0.801-0.052 1.615-0.093 2.427-0.037 0.74-0.297 0.979-1.043 0.995-0.208 0.011-0.411 0.027-0.64 0.041v1.74c0.432 0 0.833 0.027 1.235 0 1.239-0.073 1.995-0.677 2.239-1.885 0.104-0.661 0.167-1.333 0.183-2.005 0.041-0.615 0.036-1.235 0.099-1.844 0.093-0.953 0.532-1.349 1.484-1.411 0.089-0.011 0.177-0.032 0.267-0.057v-1.953c-0.161-0.021-0.271-0.037-0.391-0.041-0.713-0.032-1.068-0.272-1.251-0.948-0.109-0.433-0.177-0.876-0.197-1.324-0.052-0.823-0.047-1.656-0.099-2.479-0.109-1.588-1.063-2.339-2.516-2.38zM12.099 14.875c-1.432 0-1.536 2.109-0.115 2.245h0.079c0.609 0.036 1.131-0.427 1.167-1.037v-0.061c0.011-0.62-0.484-1.136-1.104-1.147zM15.979 14.875c-0.593-0.020-1.093 0.448-1.115 1.043 0 0.036 0 0.067 0.005 0.104 0 0.672 0.459 1.099 1.147 1.099 0.677 0 1.104-0.443 1.104-1.136-0.005-0.672-0.459-1.115-1.141-1.109zM19.927 14.875c-0.624-0.011-1.145 0.485-1.167 1.115 0 0.625 0.505 1.131 1.136 1.131h0.011c0.567 0.099 1.135-0.448 1.172-1.104 0.031-0.609-0.521-1.141-1.152-1.141z"></path></svg>
                  </div>
                  <div>
                    <a href="/swagger-ui" target="_blank" class="font-semibold text-gray-700 text-xl">Документация API</a>
                    <p class="font-semibold text-gray-400 text-sm">Изучить API для интеграции</p>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </section>
      </main>

    <footer>
    </footer>
</div>