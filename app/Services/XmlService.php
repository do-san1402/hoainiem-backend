<?php

namespace App\Services;

use App\Models\NewsMst;
use Carbon\Carbon;
use Modules\Menu\Entities\MenuContent;
use Modules\Setting\Entities\Application;

class XmlService
{

    /**
     * Create rss.xml
     *
     * @return void
     */
    public static function rss_xml()
    {
        $file_location = public_path('rss.xml');
        $settings      = Application::first();

        $to_date       = date('d-m-Y');
        $website_title = $settings->title;
        $website_logo  = $settings->logo;

        $post = NewsMst::with('postByUser', 'photoLibrary')
            ->where('status', 0)
            ->orderBy('id', 'DESC')
            ->take(16)
            ->get();

        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $xml .= "<rss version=\"2.0\"
                     xmlns:dc=\"http://purl.org/dc/elements/1.1/\"
                     xmlns:sy=\"http://purl.org/rss/1.0/modules/syndication/\"
                     xmlns:admin=\"http://webns.net/mvcb/\"
                     xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\"
                     xmlns:content=\"http://purl.org/rss/1.0/modules/content/\">\n";

        $xml .= "<channel>\n";

        $xml .= "<title>" . $website_title . " RSS Feed RSS</title>\n";
        $xml .= "<link>" . url('/') . "</link>\n";
        $xml .= "<description>Read our awesome news, every day</description>\n";
        $xml .= "<lastBuildDate>" . $to_date . "</lastBuildDate>\n";

        foreach ($post as $row) {

            $news1 = strip_tags(@$row->news);
            $news2 = htmlspecialchars_decode($news1, ENT_QUOTES);
            $news  = implode(' ', array_slice(explode(' ', $news2), 0, 20));

            $image_path = null;

            if ($row->photoLibrary && $row->photoLibrary->thumb_image) {
                $image_path = storage_asset_image($row->photoLibrary->thumb_image);
            }

            $xml .= "
                        <item>
                            <title>" . $row->title . "</title>
                            <link>" . url('/' . $row->encode_title) . "/</link>
                            <guid>" . url('/' . $row->encode_title) . "/</guid>
                            <description><![CDATA[ " . $news . " ]]></description>
                            <enclosure url='" . url('uploads/' . $row->image) . "'/>
                            <pubDate>" . $row->last_update . "</pubDate>
                            <dc:creator>" . ($row->postByUser->full_name ?? null) . "</dc:creator>
                        </item>\n
            ";

        }

        $xml .= "</channel>\n</rss>";
        file_put_contents($file_location, $xml);
    }

    /**
     * create sitemap.xml
     *
     * @return void
     */
    public static function sitemap_xml()
    {
        $file_location = public_path('sitemap.xml');
        $str           = file_get_contents($file_location);
        $to_date       = date('d-m-Y');

        $info = MenuContent::get();
        $news = NewsMst::select('encode_title')->OrderBy('news_id', 'DESC')->take(120)->get();

        $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        $xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
        $xml .= "
                <url>
                    <loc>" . url('/') . "</loc>
                    <lastmod>" . $to_date . "</lastmod>
                    <changefreq> always </changefreq>
                    <priority>1.0</priority>
                </url>\n
                ";

        foreach ($info as $key => $row) {

            if ($row->slug != '') {
                $xml .= "
                    <url>
                        <loc>" . url('category/' . $row->slug) . "/</loc>
                        <lastmod>" . Carbon::parse($row->updated_at)->format('d-m-Y') . "</lastmod>
                        <changefreq> always </changefreq>
                        <priority>1.0</priority>
                    </url>\n
                ";
            }

        }

        foreach ($news as $key => $value) {

            if ($value->encode_title != '') {
                $xml .= "
                <url>
                    <loc>" . url('/' . $value->encode_title) . "/</loc>
                    <lastmod>" . Carbon::parse($value->updated_at)->format('d-m-Y') . "</lastmod>
                    <changefreq> always </changefreq>
                    <priority>1.0</priority>
                </url>\n";
            }

        }

        $xml .= "</urlset>\n";

        file_put_contents($file_location, $xml);

    }

}
