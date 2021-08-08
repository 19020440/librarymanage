<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Repositories\Book\BookRepository;
use App\Models\Book;
use KubAT\PhpSimple\HtmlDomParser;

class AjaxController extends Controller
{
    private $bookRepository;
    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }
    public function getDataAjax()
    {
        $data = DB::table('orderdetails')->select('book_id', DB::raw('sum(quantity) as total'), DB::raw('(select name from books where book_id = id) as nameBook'))
            ->groupBy('book_id')->orderByDesc('total')->limit(8)->get();
        return $data;
    }

    public function getTotalAjax(Request $request)
    {
        $value = $request->value;
        $type = $request->type;
        $index  = array_search($value, Book::TYPE);
        if ($type == "category") {
            return DB::table('books')->select(DB::raw('sum(price) as total'))->where($type, 'like', $index . '%')->get();
        }
        return DB::table('books')->select(DB::raw('sum(price) as total'))->where($type, $value)->get();
    }

    public function dashBoardOfMonth(Request $request)
    {
        $type = $request->type;
        if ($type == 'month')
            return   DB::table('orders')->select(DB::raw('CASE WHEN DAY(created_at) between 1 and 7 THEN 1
        WHEN DAY(created_at) between 8 and 15 THEN 2
        WHEN DAY(created_at) between 16 and 23 THEN 3
        ELSE 4
        END AS weeks'), DB::raw('count(id) as total'))->whereMonth('created_at', $request->month)->whereYear('created_at', $request->year)->groupBy('weeks')->get();

        else return DB::table('orders')->select(DB::raw('CASE WHEN Month(created_at) = 1  THEN 1
        WHEN Month(created_at) = 2  THEN 2
        WHEN Month(created_at) = 3  THEN 3
        WHEN Month(created_at) = 4  THEN 4
        WHEN Month(created_at) = 5  THEN 5
        WHEN Month(created_at) = 6  THEN 6
        WHEN Month(created_at) = 7  THEN 7
        WHEN Month(created_at) = 8  THEN 8
        WHEN Month(created_at) = 9  THEN 9
        WHEN Month(created_at) = 10  THEN 10
        WHEN Month(created_at) = 11  THEN 11
        ELSE 12
        END AS months'), DB::raw('count(id) as total'))->whereYear('created_at', $request->year)->groupBy('months')->get();
    }

    public function dashBoardFromTo(Request $request)
    {
        $type = $request->type;
        if ($type == 'month') {
            $datefrom = $request->valuefrom;
            $dateto = $request->valueto;
            return DB::table('orders')->selectRaw('count(*) as total, concat(year(created_at),"-",month(created_at)) as dates')
                ->whereBetween('created_at', [$datefrom, $dateto])
                ->groupBy('dates')
                ->get();
        } else {
            $datefrom = $request->valuefrom;
            $distance = $request->value;
            return DB::table('orders')->selectRaw('count(*) as total, concat(year(created_at),"-",month(created_at),"-",day(created_at)) as days')
                ->whereRaw('created_at between ? and adddate(?, interval ? day)', [$datefrom, $datefrom, $distance])
                ->groupBy('days')
                ->get();
        }
    }

    public function searchDataByAjax(Request $request)
    {
        $data = [];
        $valueRequest = $request->category;
        if ($valueRequest != 0) return  $this->bookRepository->searchDataAjax($valueRequest);
        else return  response()
            ->json([]);
    }

    public function getDaTa(Request $request)
    {
        $link = $request->link;

        function validate($input)
        {
            if ($input != null) return $input->plaintext;
            else return '';
        }
        // function my_callback() {
        //     $html = HtmlDomParser::file_get_html("https://www.google.com.vn/search?tbm=bks&hl=vi&q=isbn%3A$link");
        //     $html2=($html->find('.kCrYT a',0)->href);
        //     return $html2;
        // }

        // $dom = HtmlDomParser::file_get_html(my_callback($link));

        // $content =  $dom ->find('#synopsistext',0)->plaintext;
        // $name = $dom -> find('h1.booktitle',0) -> plaintext;
        // $auth =  $dom ->find('.bookinfo_sectionwrap span',0) -> plaintext;
        // $publisher =  $dom ->find('#metadata_content_table',0)->children(2)->children(1)->plaintext;
        // $image =  $dom ->find('.bookcover img',0)->getAttribute('src');

        // $data = ["content" => $content,
        //         "auth" => $auth,
        //         "publisher" => $publisher,
        //         "frontImage" => $image,
        //         "name" => $name,
        //         ];
        //     return $data;
        $url = "https://www.amazon.com/dp/$link/ref=s9_acsd_hps_bw_c2_x_5_i?pf_rd_m=ATVPDKIKX0DER&pf_rd_s=merchandised-search-8&pf_rd_r=M95V84YTA4N783WWYDFK&pf_rd_t=101&pf_rd_p=471146b1-73a8-45e2-aa6e-e79125421657&pf_rd_i=283155";
        $html = HtmlDomParser::file_get_html($url);
        $publisher = '';
        $content =  validate($html->find('#bookDescription_feature_div', 0));
        // $publisher =  validate($html -> find('#detailBullets_feature_div #detailBullets_feature_div li span',0)->children(1));
        // echo $html -> find('#detailBullets_feature_div #detailBullets_feature_div li');
        foreach ($html->find('#detailBullets_feature_div #detailBullets_feature_div li') as $li) {
            if (strpos($li->plaintext, "Publisher") !== false) {
                $publisher = $li->find('span span', 1)->plaintext;
                break;
            }
        }
        $behindImage =  $html->find('#imageBlockThumbs span', 0)->children(1)->children(0)->getAttribute('src');
        $frontImage =  $html->find('#img-canvas img', 0)->getAttribute('src');
        $name =  validate($html->find('#productTitle', 0));
        $auth =  validate($html->find('a.contributorNameID', 0));
        $price = '';

        $arr = array();
        foreach ($html->find('#tmmSwatches ul li') as $li) {
            array_push($arr, $li->find('a span', 1)->plaintext);
        }
        if (count($arr) >= 3) {
            $price = $arr[2];
        } else if (count($arr) == 0) {
            $price = 0;
        } else $price = $arr[0];
        $data = [
            "content" =>  "$content",
            "price" => $price,
            "publisher" => $publisher,
            "behindImage" => $behindImage,
            "frontImage" => $frontImage,
            "name" => $name,
            "auth" => $auth,

        ];
        $data = json_encode($data);
        return $data;
    }
}
