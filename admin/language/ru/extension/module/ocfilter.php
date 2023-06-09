<?php

// COMMON
$_['heading_title'] = '<strong style="color:#41637d">DEV-OPENCART.COM —</strong> Фильтр товаров OCFilter 4.8 <a href="https://dev-opencart.com" target="_blank" title="Dev-opencart.com - Модули и шаблоны для Opencart"><img style="margin-left:15px;height:35px;margin-top:10px;margin-bottom:10px;" src="https://dev-opencart.com/logob.svg" alt="Dev-opencart.com - Модули и шаблоны для Opencart"/></a>';
$_['heading_title_setting'] = 'Фильтр товаров OCFilter';
$_['button_apply'] = 'Применить';
$_['text_module'] = 'Модули';
$_['text_edit'] = 'Настройки фильтра товаров OCFilter <span class="badge" data-toggle="tooltip" data-placement="top" title="%s">%s</span>';
$_['text_select'] = '-- Выберите --';
$_['text_selected'] = 'Выбрано';
$_['text_success'] = 'Вы успешно обновили настройки модуля &laquo;Фильтр товаров OCFilter&raquo;!';
$_['text_filter_list'] = 'Фильтры';
$_['text_filter_page_list'] = 'SEO Страницы';
$_['text_faq'] = 'FAQ';
$_['text_documentation'] = 'Документация';
$_['text_ocfilter'] = 'OCFilter';
$_['text_ocfilter_filter'] = 'Фильтры';
$_['text_ocfilter_page'] = 'Страницы';
$_['text_ocfilter_setting'] = 'Настройки';
$_['text_loading'] = '<i class=\'fa fa-refresh fa-spin\'></i> Загрузка..';
$_['text_complete'] = '<i class=\'fa fa-check\'></i> Готово';

$_['text_filters'] = 'фильтров';
$_['text_values'] = 'значений фильтра';

$_['entry_sort_order'] = 'Сортировка';
$_['text_begin'] = 'В начале';
$_['text_after'] = 'В конце';
$_['help_sort_order'] = 'Чтобы указать точную позицию щелкните по текстовому полю';

$_['entry_type'] = 'Тип';

// Error
$_['error_permission'] = 'Внимание: у вас нет прав для редактирования этого модуля!';
$_['error_copy_type'] = 'Пожалуйста, укажите тип будущих фильтров';
$_['error_license'] = 'Лицензионный ключ неверный!';
$_['error_license_empty'] = 'Пожалуйста, укажите лицензионный ключ!';

// TAB GENERAL
$_['tab_general'] = 'Основное';

$_['entry_license'] = 'Лицензионный ключ';
$_['help_license'] = 'Укажите полученный при покупке ключ лицензии. Если вы не получили ключ либо возникли другие проблемы с активацией модуля, напишите на <a href="mailto:opencart.ocfilter@gmail.com?subject=Проблема%20с%20активацией%20OCFilter">opencart.ocfilter@gmail.com</a>';

$_['entry_status'] = 'Статус';
$_['help_status'] = 'Включает или выключает модуль';

$_['entry_category_visibility'] = 'Видимость в категориях';
$_['text_category_visibility_default'] = 'Как указано фильтрам';
$_['help_category_visibility_default'] = 'Фильтры будут выводиться только в тех категориях, которые им указаны в форме редактирования фильтра';
$_['text_category_visibility_parent'] = 'Показывать в родительских';
$_['help_category_visibility_parent'] = 'Выводить фильтры <b>из дочерних</b> категорий <b>в родительские</b> даже если они им не назначены явно';
$_['text_category_visibility_last_level'] = 'Выводить только на последнем уровне';
$_['help_category_visibility_last_level'] = 'Модуль будет работать только на <b>последнем уровне</b> вложенности категорий';

$_['entry_hide_categories'] = 'Скрывать категории при выборе фильтров';

$_['entry_only_instock'] = 'Работать только с товарами в наличии';
$_['help_only_instock'] = 'Это значит, что товары с нулевым количеством не будут попадать в фильтры поиска.<br />Если у значения фильтра все товары не в наличии - оно также скроется.';

$_['entry_search_button'] = 'Фильтровать по кнопке';
$_['help_search_button'] = 'Позволяет сначала выбрать необходимые фильтры, затем произвести поиск товаров';

$_['entry_cache'] = 'Кэширование данных';
$_['help_cache'] = 'Управление кэшированием данных модуля. Внимание! Используйте отключение только в целях отладки. Включенный кэш значительно ускоряет работу модуля.';

$_['entry_cache_store'] = 'Хранилище кэша';
$_['text_cache_db'] = 'База данных';
$_['text_cache_system'] = 'Как задано системой (%s)';

$_['entry_debug'] = 'Отладка запросов';
$_['help_debug'] = '';

$_['nav_general_compatibility'] = 'Совместимость с другими модулями';

$_['entry_module_hpm_group_products'] = 'Группировать найденные товары';
$_['help_module_hpm_group_products'] = 'При поиске фильтром показывать только сгруппированные товары';

$_['entry_module_hpm_group_counter'] = 'Группы в счетчике товаров';
$_['help_module_hpm_group_counter'] = 'Счетчик товаров у каждого значения будет отображать количество сгруппированных товаров';

// TAB SPECIAL FILTERS
$_['tab_special_filter'] = 'Специальные фильтры';

// -------------------------------------------------------------- //
$_['tab_price'] = 'Цена';

$_['entry_special_price'] = 'Фильтр по цене';
$_['entry_special_price_logarithmic'] = 'Логарифмическая шкала цены';

$_['entry_consider_tax'] = 'Учитывать налоги';
$_['help_consider_tax'] = 'К ценам будут прибавляться налоги с учётом группы покупателей';

$_['nav_price_source'] = 'Источники цен <div class="small">можно комбинировать или оставить один</div>';

$_['entry_special_price_consider_regular_price'] = 'Обычная цена';
$_['help_special_price_consider_regular_price'] = 'Использование стандартной (обычной) цены товара';

$_['entry_special_price_consider_discount'] = 'Цена со скидкой';
$_['help_special_price_consider_discount'] = 'Включает цены со скидками';

$_['entry_special_price_consider_special'] = 'Акционная цена';
$_['help_special_price_consider_special'] = 'Учитывать акционную цену';

$_['entry_special_price_consider_option'] = 'Цена опций товара';
$_['help_special_price_consider_option'] = 'Диапазон цен расширится до границ цен указанных в опциях.<br />Доступные операторы для расчета цены: +, -, *, /, =';

// -------------------------------------------------------------- //
$_['tab_manufacturer'] = 'Производитель';

$_['entry_special_manufacturer'] = 'Фильтр по производителям';
$_['help_special_manufacturer'] = 'Позволяет фильтровать товары по стандартным производителям';

$_['entry_special_manufacturer_dropdown'] = 'Выпадающий список';
$_['entry_special_manufacturer_image'] = 'Выводить изображения';

// -------------------------------------------------------------- //
$_['tab_discount'] = 'Скидка';

$_['entry_special_discount'] = 'Только со скидкой';
$_['help_special_discount'] = 'Фильтр предлагает выбрать товары со сниженной ценой';
$_['entry_special_discount_consider_special'] = 'Учитывать акции';
$_['entry_special_discount_consider_discount'] = 'Учитывать скидки';

// -------------------------------------------------------------- //
$_['tab_newest'] = 'Новинка';

$_['entry_special_newest'] = 'Только новые';
$_['help_special_newest'] = 'Фильтр предлагает выбрать только новые товары';

$_['entry_special_newest_interval'] = 'Признак нового товара';
$_['text_special_newest_interval_hour'] = 'Часов';
$_['text_special_newest_interval_day'] = 'Дней';
$_['text_special_newest_interval_week'] = 'Недель';
$_['text_special_newest_interval_month'] = 'Месяцев';
$_['help_special_newest_interval'] = 'Товар считается новым, если добавлен не позже указанного периода';

// -------------------------------------------------------------- //
$_['tab_dimension'] = 'Размеры и вес';

$_['entry_special_weight'] = 'Вес товара';
$_['entry_special_width'] = 'Ширина';
$_['entry_special_height'] = 'Высота';
$_['entry_special_length'] = 'Длина';

// -------------------------------------------------------------- //
$_['tab_stock'] = 'Склад';

$_['entry_special_stock'] = 'Фильтр по наличию на складе';
$_['help_special_stock'] = 'Даёт возможность фильтровать товары по наличию на складе';

$_['entry_special_stock_method'] = 'Метод';
$_['text_special_stock_method_by_status_id'] = 'По статусу склада товара';
$_['text_special_stock_method_by_quantity'] = 'По количеству товара';

$_['entry_special_stock_out_value'] = 'Показывать значение &laquo;Нет в наличии&raquo;';

// TAB SEO
$_['tab_seo'] = 'SEO';

// -------------------------------------------------------------- //
$_['nav_seo_page'] = 'Посадочные страницы';

$_['entry_sitemap'] = 'Sitemap посадочных страниц фильтра';
$_['entry_sitemap_link'] = 'Ссылка на Sitemap';

$_['entry_page_category_link_status'] = 'Выводить ссылки на страницы категорий';
$_['help_page_category_link_status'] = 'Ссылки на посадочные страницы будут выведены в категориях в виде тегов. Названия ссылок берется из поля &laquo;Название&raquo;';

$_['entry_page_category_link_position'] = 'Позиция ссылок в категории';
$_['text_page_category_link_above'] = 'Над товарами';
$_['text_page_category_link_under'] = 'Под товарами';
$_['text_page_category_link_both'] = 'Распределить поровну';

$_['entry_page_module_link_status'] = 'Выводить ссылки в модуле';
$_['help_page_module_link_status'] = 'Ссылки на посадочные страницы будут выведены в верхней части модуля';

$_['entry_page_module_link_title'] = 'Название блока ссылок';
$_['page_module_link_title'] = 'Популярные фильтры';

$_['entry_page_product_link_status'] = 'Выводить ссылки в характеристиках товара';
$_['help_page_product_link_status'] = 'Ссылки на посадочные страницы можно привязать к характеристикам товара';

$_['entry_page_product_link_relation_type'] = 'Логика привязки страниц к атрибутам';
$_['text_page_product_link_relation_complete'] = 'Полное соответствие';
$_['text_page_product_link_relation_partial'] = 'Частичное соответствие';
$_['help_page_product_link_relation_type'] = 'При <b>полном соответствии</b> к товару будут применены те посадочные страницы, у которых все фильтры совпадают с атрибутами товаров.<br />Например, вы создали страницу к фильтру &laquo;Цвет: красный&raquo;, &laquo;Размер: средний&raquo;. Страница будет выводиться только в тех товарах, которые имеют атрибут <br />&laquo;Цвет: красный&raquo; <b>и</b> &laquo;Размер: средний&raquo;.<br /><b>Частичное соответствие</b> свяжет товары со страницами при условии, что хотя бы один фильтр посадочной страницы будет упоминаться в атрибутах товара.';

$_['entry_url_suffix'] = 'Окончание ссылки';
$_['placeholder_url_suffix'] = 'Например, .html';

// -------------------------------------------------------------- //
$_['nav_seo_meta'] = 'Автоматические мета данные <div class="small">Эти данные нужны только для ваших покупателей и только для тех фильтров, которым не указана посадочная страница. Поисковая система их не увидит</div>';

$_['entry_add_meta'] = 'Добавлять в мета данные';
$_['text_add_meta_filter_value'] = 'Фильтры и значения';
$_['text_add_meta_value'] = 'Только значения';
$_['text_add_meta_disabled'] = 'Не добавлять';

$_['entry_meta_filter_separator'] = 'Разделитель фильтров';
$_['entry_meta_value_separator'] = 'Разделитель значений';
$_['entry_meta_lowercase'] = 'Строчными буквами';
$_['entry_add_meta_limit'] = 'Добавлять не более';

// -------------------------------------------------------------- //
$_['nav_seo_misc'] = 'Разное';

$_['entry_category_breadcrumb'] = 'Добавлять хлебную крошку в категории';
$_['help_category_breadcrumb'] = 'Добавлять хлебную крошку с выбранными фильтрами (или посадочной страницей) на странице категории. Эффективность данной настройки для SEO не изучна, поэтому до её активации лучше проконсультируйтесь со своим SEO специалистом';

$_['entry_product_breadcrumb'] = 'Добавлять хлебную крошку в товаре';
$_['help_product_breadcrumb'] = 'Добавлять хлебную крошку с выбранными фильтрами (или посадочной страницей) на страницу товара между категорией и товаром. Как и в случае выше, необходимость включения данной настройки требует уточнения';

// TAB APPEARANCE
$_['tab_appearance'] = 'Внешний вид';

// -------------------------------------------------------------- //
$_['nav_appearance_module'] = 'Модуль и мобильная версия';

$_['entry_module_heading_title'] = 'Заголовок модуля';
$_['module_heading_title'] = 'Фильтр';

$_['entry_mobile_button_text'] = 'Текст кнопки вызова мобильной версии';
$_['mobile_button_text'] = 'Фильтр';

$_['entry_mobile_button_position'] = 'Позиция кнопки мобильной версии';
$_['text_mobile_button_position_fixed'] = 'Плавающая';
$_['text_mobile_button_position_static'] = 'Статическая над товарами';
$_['text_mobile_button_position_both'] = 'Оба варианта';

$_['entry_mobile_max_width'] = 'Ширина экрана мобильной версии';
$_['help_mobile_max_width'] = 'Укажите максимальную ширину экрана (в пикселях), при которой модуль будет оставаться в режиме мобильной версии.<br />По умолчанию это 767 пикселей, что равняется значению переключения sm для Bootstrap 3';

$_['entry_mobile_placement'] = 'Расположение мобильной версии';
$_['text_mobile_placement_left'] = 'Слева';
$_['text_mobile_placement_right'] = 'Справа';

$_['entry_mobile_remember_state'] = 'Помнить состояние окна мобильной версии';
$_['help_mobile_remember_state'] = 'Включение данной настройки приведет к восстановлению окна мобильной версии после перезагрузки страницы';

// -------------------------------------------------------------- //
$_['nav_appearance_filter'] = 'Фильтры';

$_['entry_theme'] = 'Тема';
$_['text_theme_light'] = 'Светлая';
$_['text_theme_light_block'] = 'Светлая блочная';

$_['entry_show_first_limit'] = 'Показывать только первые';
$_['help_show_filters_limit'] = 'Укажите лимит количества фильтров, которые будут выводиться в модуле фильтра товаров. Чтобы выводить все фильтры, укажите 0';

$_['entry_hidden_filters_lazy_load'] = '&laquo;Ленивая&raquo; загрузка фильтров';
$_['help_hidden_filters_lazy_load'] = 'Загружать скрытые фильтры в фоновом режиме (AJAX).<br />Эта настройка может облегчить страницы с большим количеством фильтров и повысить показатели Google PageSpeed.';

$_['entry_hide_single_value'] = 'Скрывать фильтры с одним значением';
$_['help_hide_single_value'] = 'Не выводит фильтры у которых только одно активное значение';

$_['entry_slider_input'] = 'Поля ввода для слайдеров';
$_['help_slider_input'] = 'Позволяет вводить значения для слайдеров в отдельные поля';

$_['entry_show_diagram'] = 'Диаграмма';
$_['help_show_diagram'] = 'Графическое отображение отношения количества товаров к значению диапазона';

$_['entry_slider_pips'] = 'Шкала со значениями';

$_['entry_show_selected'] = 'Показывать выбранные параметры';
$_['help_show_selected'] = 'Отображает блок выбранных параметров с возможностью исключения их из запроса';

// -------------------------------------------------------------- //
$_['nav_appearance_filter_value'] = 'Значения';

$_['entry_show_counter'] = 'Показывать счетчик товаров';
$_['help_show_counter'] = 'Отображает количество товаров для каждого значения.<br />На скорость загрузки страницы этот параметр не влияет';

$_['help_show_values_limit'] = 'Укажите лимит количества значений, которые будут выводиться в модуле фильтра товаров для каждого фильтра. Чтобы выводить все значения, укажите 0';

$_['entry_hidden_values_lazy_load'] = '&laquo;Ленивая&raquo; загрузка значений';
$_['help_hidden_values_lazy_load'] = 'Аналогично фильтрам. При включении этой опции подгрузка скрытых значений фильтра осуществляется в фоновом режиме.';

$_['entry_hide_empty_values'] = 'Скрывать неактивные значения';
$_['help_hide_empty_values'] = 'Полностью скрывает неактивные (с нулевым показателем товаров) значения фильтров. В случае, если будут скрыты все значения - скрывается и сам фильтр';

$_['entry_values_auto_column'] = 'Разбивать значения на колонки';
$_['help_values_auto_column'] = 'Автоматически разбивать значения на колонки (2 или 3) в зависимости от длины их названий.';

// TAB PLACEMENT
$_['tab_placement'] = 'Размещение';
$_['text_placement'] = 'Укажите макеты (схемы) и фильтры, которые должны выводиться на них.<br />Также необходимо добавить модуль в соответствующий макет в разделе <a href="%s" class="alert-link" target="_blank"><u>Дизайн - Макеты (Схемы / Шаблоны)</u></a><br /><b class="text-danger">Внимание!</b> Не используйте эту настройку для вывода модуля в макетах &laquo;Категория&raquo;, &laquo;Производитель&raquo;, &laquo;Акции&raquo; и &laquo;Поиск&raquo;. Просто добавьте модуль в эти макеты и все.';
$_['text_new_placement'] = '-- Новое --';

$_['button_add_placement'] = 'Добавить размещение';
$_['button_remove_placement'] = 'Удалить размещение';

$_['entry_placement_layout'] = 'Укажите макет';
$_['entry_placement_filter'] = 'Добавьте фильтры';
$_['placeholder_autocomplete'] = 'Начинайте вводить название';

// TAB COPY FILTERS
$_['tab_copy'] = 'Копирование фильтров';
$_['text_confirm_truncate_copy'] = 'Вы уверены, что хотите очистить\nвсе существующие фильтры OCFilter?';

// -------------------------------------------------------------- //
$_['nav_copy_source'] = 'Источники фильтров';

$_['entry_copy_attribute'] = 'Копировать атрибуты';
$_['text_copy_attribute_total'] = 'Атрибутов: <b>%s</b>, значений: <b>%s</b>';

$_['entry_copy_group_as_attribute'] = 'Группы атрибутов как фильтры';
$_['help_copy_group_as_attribute'] = 'Если <b>группы</b> атрибутов являются <b>фильтрами</b>, атрибуты - <b>значениями</b>, а в форме товара во вкладке &laquo;Атрибуты&raquo; поле &laquo;<b>Текст</b>&raquo; (справа) не заполнено - укажите &laquo;Да&raquo;';

$_['entry_copy_attribute_data'] = 'Данные для копирования';
$_['help_copy_attribute_data'] = 'Укажите данные атрибутов для копирования в фильтры.<br />Вы можете выбрать конкретные атрибуты, категории, либо группы атрибутов (если используется режим &laquo;<kbd>Группы атрибутов как фильтры</kbd>&raquo;).<br />Любые данные можно исключить из копирования соответствующей опцией.<br />Кнопка &laquo;<kbd>Авто</kbd>&raquo; позволяет получить список вероятно подходящих атрибутов под выбранный режим выборки.<br />Если эти поля останутся пустыми, то скопируются все атрибуты.';

$_['entry_copy_exclude'] = 'Исключить';

$_['placeholder_copy_attribute_autocomplete'] = 'Атрибут';
$_['placeholder_copy_attribute_group_autocomplete'] = 'Группа атрибута';
$_['placeholder_copy_category_autocomplete'] = 'Категория';

$_['button_clear'] = 'Очистить';
$_['button_auto'] = 'Авто';

$_['entry_copy_filter'] = 'Копировать стандартные фильтры';
$_['text_copy_filter_total'] = 'Фильтров: <b>%s</b>, значений: <b>%s</b>';

$_['entry_copy_option'] = 'Копировать опции товаров';
$_['text_copy_option_total'] = 'Опций: <b>%s</b>, значений: <b>%s</b>';

$_['entry_copy_option_in_stock'] = 'Только в наличии';
$_['help_copy_option_in_stock'] = 'Копировать опции только с положительным остатком товаров';

// -------------------------------------------------------------- //
$_['nav_copy_filter'] = 'Настройки результирующих фильтров <div class="small">Которые появятся после копирования. На уже существующие фильтры эти настройки не влияют.</div>';

$_['entry_copy_type'] = 'Тип скопированных фильтров';
$_['entry_copy_dropdown'] = 'Поместить в выпадающий список';

$_['entry_copy_status'] = 'Статус скопированных фильтров';
$_['help_copy_status'] = 'Статус новых фильтров, которые будут созданы из указанных источников.<br />Независимо от выбранного статуса, отключены будут те фильтры, у которых нет значений или они не привязаны к товарам либо категориям';

// -------------------------------------------------------------- //
$_['nav_copy_other'] = 'Другое';

$_['entry_copy_value_separator'] = 'Разделитель значений';
$_['placeholder_copy_value_separator'] = 'Например, «/»';
$_['help_copy_value_separator'] = 'Чтобы разбить одно составное значение фильтра на одиночные, используйте разделитель значений фильтра.<br />Например, для разделения значения &laquo;Зеленый / Красный / Синий&raquo; фильтра &laquo;Цвет&raquo; на отдельные цвета, используйте разделитель &laquo;/&raquo;.<br />Можно использовать до 3-х разделителей одновременно';

$_['entry_copy_clear_filter'] = 'Очистить существующие фильтры OCFilter';
$_['help_copy_clear_filter'] = 'Удалятся только ранее скопированные фильтры. Добавленные вручную останутся нетронутыми.';

$_['entry_copy_category'] = 'Привязать фильтры к категориям';
$_['help_copy_category'] = 'При выборе этой опции все существующие связи фильтров OCFilter с категориями будут обновлены. Фильтры, добавленные вручную, свои связи с категориям не изменят.';

// -------------------------------------------------------------- //
$_['nav_copy_auto'] = 'Автоматизация';

$_['text_copy_auto_code_php'] = 'PHP Код для вызова копирования с текущими настройками';
$_['help_copy_auto_code_php'] = 'Вставьте этот код в конец сценария импорта товаров, скрипт парсинга либо другое место, где имеет смысл вызвать копирование.';

$_['text_copy_auto_code_js'] = 'JS Код для вызова копирования с текущими настройками';
$_['help_copy_auto_code_js'] = 'Код можно разместить в любом месте шаблона, вызове по событию и т.д.';

$_['text_copy_auto_cron'] = 'Команда для вызова по cron (планировщик)';
$_['help_copy_auto_cron'] = 'Удобный редактор периода для cron <a href="https://crontab.guru/" target="_blank">здесь</a><br />После указания параметров копирования <b>обязательно</b> сохраните настройки';
$_['text_cron_select_period'] = 'Выберите период копирования<br />либо укажите свой';
$_['text_cron_period'] = 'Период';
$_['text_cron_period_01'] = 'Каждый час';
$_['text_cron_period_02'] = 'Каждые 3 часа';
$_['text_cron_period_03'] = 'Каждые сутки в 04:00';
$_['text_cron_period_04'] = 'Каждое воскресенье в 04:00';
$_['text_cron_period_05'] = 'Каждые 5 часов в выходные';
$_['text_cron_period_06'] = 'Каждого 1-го числа нового месяца';
$_['text_or'] = 'или';
$_['text_cron_period_manual'] = 'Свой период';
$_['text_cron_bin'] = 'Команда добавления вызова через PHP bin';
$_['text_cron_wget'] = 'Разрешить вызывать через Wget';

$_['entry_copy_now'] = 'Копировать сейчас';
$_['button_copy'] = 'Копировать';
$_['entry_copy_save_setting'] = 'И сохранить все текущие настройки копирования';

$_['error_install_modification_not_found'] = 'Модификатор ' . DIR_SYSTEM . 'ocfilter.ocmod.xml не найден. Скопируйте модификатор по указанному пути и повторите установку.';
$_['error_install_modification_update'] = 'Пожалуйста, обновите модификаторы с запущенной консолью браузера (F12) и попробуйте снова настроить модуль.';
$_['error_install_tables'] = 'Пожалуйста, удалите модуль из списка модулей и установите по кнопке &laquo;Установить&raquo; из этого же списка модулей.';