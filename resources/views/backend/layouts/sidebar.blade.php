<!-- Sidebar  -->
<nav class="sidebar sidebar-bunker">
    <div class="sidebar-header">
        <a href="{{ route('home') }}" class="sidebar-brand w-100">
            <img class="sidebar-logo sidebar_brand_icon w-100"
                src="{{ app_setting()->sidebar_logo ?? asset('assets/logo.png') }}" alt="{{ localize('logo') }}">
            <img class="collapsed-logo" src="{{ app_setting()->sidebar_collapsed_logo ?? asset('assets/mini-logo.png') }}"
                alt="{{ localize('logo') }}">
        </a>
    </div>
    <!--/.sidebar header-->
    <div class="sidebar-body">
        <div class="search sidebar-form">
            <div class="search__inner sidebar-search">
                <input id="search" type="text" class="form-control search__text" placeholder="Menu Search..."
                    autocomplete="off">
                {{-- <i class="typcn typcn-zoom-outline search__helper" data-sa-action="search-close"></i> --}}
            </div>
        </div>
        <nav class="sidebar-nav">
            <ul class="metismenu">
                @can('read_dashboard')
                    <li class="{{ request()->is('dashboard') ? 'mm-active' : '' }}">
                        <a href="{{ route('home') }}">
                            <i class="fa fa-home"></i>
                            <span>{{ localize('dashboard') }}</span>
                        </a>
                    </li>
                @endcan

                @canany(['create_news', 'read_news'])
                    <li class="{{ request()->is('news*') ? 'mm-active' : '' }}">
                        <a class="has-arrow material-ripple" href="#">
                            <i class="fa fa-th-list"></i>
                            <span> {{ localize_uc('news') }}</span>
                        </a>
                        <ul class="nav-second-level {{ request()->is('news*') ? 'mm-show' : '' }}">
                            @can('create_news')
                                <li class="{{ (request()->routeIs('news.create') || request()->routeIs('news.edit')) ? 'mm-active' : '' }}">
                                    <a class="dropdown-item" href="{{ route('news.create') }}">{{ localize_uc('add_news') }}</a>
                                </li>
                            @endcan
                            @can('read_news')
                                <li class="{{ request()->routeIs('news.index') ? 'mm-active' : '' }}">
                                    <a class="dropdown-item" href="{{ route('news.index') }}">{{ localize_uc('news_list') }}</a>
                                </li>
                            @endcan
                            @can('read_post')
                                <li class="{{ request()->routeIs('news.post.*') ? 'mm-active' : '' }}">
                                    <a class="dropdown-item" href="{{ route('news.post.create') }}">{{ localize_uc('photo_post') }}</a>
                                </li>
                            @endcan
                            @can('read_breaking_news')
                                <li class="{{ request()->routeIs('news.breaking-news.index') ? 'mm-active' : '' }}">
                                    <a class="dropdown-item" href="{{ route('news.breaking-news.index') }}">{{ localize_uc('breaking_news') }}</a>
                                </li>
                            @endcan
                            @can('read_positioning')
                                <li class="{{ request()->routeIs('news.position.index') ? 'mm-active' : '' }}">
                                    <a class="dropdown-item" href="{{ route('news.position.index') }}">{{ localize_uc('positioning') }}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @canany(['create_media_library', 'read_media_library'])
                    <li class="{{ request()->is('photo-library*') ? 'mm-active' : '' }}">
                        <a class="has-arrow material-ripple" href="#">
                            <i class="fa fa-film"></i>
                            <span> {{ localize_uc('media_library') }}</span>
                        </a>
                        <ul class="nav-second-level {{ request()->is('photo-library*') ? 'mm-show' : '' }}">
                            @can('create_media_library')
                                <li class="{{ request()->routeIs('photo-library.create') ? 'mm-active' : '' }}">
                                    <a class="dropdown-item" href="{{ route('photo-library.create') }}">{{ localize_uc('photo_upload') }}</a>
                                </li>
                            @endcan
                            @can('read_photo_list')
                                <li class="{{ request()->routeIs('photo-library.index') ? 'mm-active' : '' }}">
                                    <a class="dropdown-item" href="{{ route('photo-library.index') }}">{{ localize_uc('photo_list') }}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @canany(['read_menu_setup'])
                    <li class="{{ request()->is('menu*') ? 'mm-active' : '' }}">
                        <a class="has-arrow material-ripple" href="#">
                            <i class="fas fa-gift"></i>
                            <span> {{ localize_uc('menu') }}</span>
                        </a>
                        <ul class="nav-second-level {{ request()->is('menu*') ? 'mm-show' : '' }}">
                            @can('read_menu_setup')
                                <li class="{{ request()->routeIs('menu.index') ? 'mm-active' : '' }}">
                                    <a class="dropdown-item" href="{{ route('menu.index') }}">{{ localize_uc('menu_list') }}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan


                @can('read_category')
                    <li class="{{ request()->is('category*') ? 'mm-active' : '' }}">
                        <a class="has-arrow material-ripple" href="#">
                            <i class="fa fa-tags"></i>
                            <span> {{ localize('categories') }}</span>
                        </a>
                        <ul class="nav-second-level {{ request()->is('category*') ? 'mm-show' : '' }}">
                            <li class="{{ request()->is('category/list_of_categories') ? 'mm-active' : '' }}">
                                <a class="dropdown-item" href="{{ route('category.index') }}">{{ ucwords(localize('category_list')) }}</a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('read_archive_setting')
                    <li class="{{ request()->is('archive*') ? 'mm-active' : '' }}">
                        <a class="has-arrow material-ripple" href="#">
                            <i class="fa fa-archive"></i>
                            <span> {{ ucwords(localize('archive')) }}</span>
                        </a>
                        <ul class="nav-second-level {{ request()->is('archive*') ? 'mm-show' : '' }}">
                            <li class="{{ request()->is('archive/maximum_archive_settings_view') ? 'mm-active' : '' }}">
                                <a class="dropdown-item" href="{{ route('archive.index') }}">{{ ucwords(localize('archive_setting')) }}</a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('read_advertise')
                    <li class="{{ request()->is('advertise*') ? 'mm-active' : '' }}">
                        <a class="has-arrow material-ripple" href="#">
                            <i class="fa fa-volume-up"></i>
                            <span> {{ localize('advertisement') }}</span>
                        </a>
                        <ul class="nav-second-level {{ request()->is('advertise*') ? 'mm-show' : '' }}">
                            <li class="{{ request()->is('advertise/view_ads') ? 'mm-active' : '' }}">
                                <a class="dropdown-item" href="{{ route('advertise.index') }}">{{ ucwords(localize('advertisement_list')) }}</a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('read_rss_sitemap_link')
                    <li class="{{ request()->is('rss_feeds*') ? 'mm-active' : '' }}">
                        <a class="has-arrow material-ripple" href="#">
                            <i class="fa fa-rss"></i>
                            <span> {{ ucwords(localize('rss_feeds')) }}</span>
                        </a>
                        <ul class="nav-second-level {{ request()->is('rss_feeds*') ? 'mm-show' : '' }}">
                            <li class="{{ request()->is('rss_feeds/rss-sitemap') ? 'mm-active' : '' }}">
                                <a class="dropdown-item" href="{{ route('rss_feeds.index') }}">{{ localize('rss_and_sitemap_link') }}</a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('read_reporter')
                    <li class="{{ request()->is('reporter*') ? 'mm-active' : '' }}">
                        <a class="has-arrow material-ripple" href="#">
                            <i class="fa fa-user"></i>
                            <span> {{ ucwords(localize('reporter')) }}</span>
                        </a>
                        <ul class="nav-second-level {{ request()->is('reporter*') ? 'mm-show' : '' }}">
                            <li class="{{ request()->is('reporter/reporter-list') ? 'mm-active' : '' }}">
                                <a class="dropdown-item" href="{{ route('reporter.index') }}">{{ ucwords(localize('reporter_list')) }}</a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('read_page')
                    <li class="{{ request()->is('page*') ? 'mm-active' : '' }}">
                        <a class="has-arrow material-ripple" href="#">
                            <i class="fa fa-list"></i>
                            <span> {{ ucwords(localize('page')) }}</span>
                        </a>
                        <ul class="nav-second-level {{ request()->is('page*') ? 'mm-show' : '' }}">
                            @can('create_page')
                                <li class="{{ request()->is('page/create-new-page') ? 'mm-active' : '' }}">
                                    <a class="dropdown-item" href="{{ route('page.create') }}">{{ ucwords(localize('add_new_page')) }}</a>
                                </li>
                            @endcan
                            <li class="{{ request()->is('page/pages') ? 'mm-active' : '' }}">
                                <a class="dropdown-item" href="{{ route('page.index') }}">{{ ucwords(localize('page_list')) }}</a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('read_seo')
                    <li class="{{ request()->is('seo*') ? 'mm-active' : '' }}">
                        <a class="has-arrow material-ripple" href="#">
                            <i class="fa fa-random"></i>
                            <span> {{ strtoupper(ucwords(localize('seo'))) }}</span>
                        </a>
                        <ul class="nav-second-level {{ request()->is('seo*') ? 'mm-show' : '' }}">
                            @can('read_meta_setting')
                                <li class="{{ request()->is('seo/meta-setting') ? 'mm-active' : '' }}">
                                    <a class="dropdown-item" href="{{ route('seo.index') }}">{{ ucwords(localize('meta_setting')) }}</a>
                                </li>
                            @endcan
                            @can('read_social_site')
                                <li class="{{ request()->is('seo/social-sites') ? 'mm-active' : '' }}">
                                    <a class="dropdown-item" href="{{ route('seo.social_sites') }}">{{ ucwords(localize('social_site')) }}</a>
                                </li>
                            @endcan
                            @can('read_social_link')
                                <li class="{{ request()->is('seo/social-link') ? 'mm-active' : '' }}">
                                    <a class="dropdown-item" href="{{ route('seo.social_link') }}">{{ ucwords(localize('social_link')) }}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('read_web_setup')
                    <li class="{{ request()->is('web-setup*') ? 'mm-active' : '' }}">
                        <a class="has-arrow material-ripple" href="#">
                            <i class="fa fa-gear"></i>
                            <span> {{ ucwords(localize('web_setup')) }}</span>
                        </a>
                        <ul class="nav-second-level {{ request()->is('web-setup*') ? 'mm-show' : '' }}">
                            @can('read_setup_top_breaking_post')
                                <li class="{{ request()->is('web-setup/setup-top-breaking') ? 'mm-active' : '' }}">
                                    <a class="dropdown-item" href="{{ route('view_setup.index') }}">{{ ucwords(localize('setup_top_breaking_post')) }}</a>
                                </li>
                            @endcan
                            @can('read_home_page')
                                <li class="{{ request()->is('web-setup/home-page-settings') ? 'mm-active' : '' }}">
                                    <a class="dropdown-item" href="{{ route('view_setup.home_page_setup') }}">{{ ucwords(localize('home_page')) }}</a>
                                </li>
                            @endcan
                            @can('read_contact_page_setup')
                                <li class="{{ request()->is('web-setup/contact-page-setup') ? 'mm-active' : '' }}">
                                    <a class="dropdown-item" href="{{ route('view_setup.contact_page_setup') }}">{{ ucwords(localize('contact_page_setup')) }}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('read_setting')
                    <li
                        class="{{ request()->is('setting*') || request()->is('role*') || request()->is('applications*') || request()->is('currencies*') || request()->is('mails*') || request()->is('sms*') || request()->is('password*') || request()->is('user*') || request()->is('localize*') || request()->is('database-backup-reset*') || request()->is('access-log*') ? 'mm-active' : '' }}">
                        @can('read_application')
                            <a href="{{ route('applications.application') }}">
                                <i class="fa fa-cogs"></i>
                                <span>{{ localize('settings') }}</span>
                            </a>
                        @endcan
                    </li>
                @endcan
            </ul>
        </nav>
    </div>
    <!-- sidebar-body -->
</nav>
