<?php


class IndexController extends BaseController {

    public function init() {
       

    }





    public function indexAction() {

        echo "开始爬取内容...\n";
        $this->loadFile('shiyanlou.html');
        $this->parseContent();
        return false;
    }

    private $content;
    private $data;
    private static $mysql;


    public function loadFile($file_path)
    {
        echo "正在加载文件...\n";
        $this->content = file_get_contents('http://labfile.oss.aliyuncs.com/contestlou5/shiyanlou.html');
    }

    public function parseCourseBody()
    {

        $subject = "1a23b";
         preg_match('/[\w]{2}/is', $subject,$a);
        var_dump($a);
        $a = preg_split('/([\d])/', $subject, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        var_dump($a);die;
        // s修饰符与.组合执行可匹配换行
        $course_body = '#<div class="course-body">.*<div class="course-name">(.*?)</div>.*<div class="course-desc">(.*?)</div>
        	.*<span class="course-bootcamp pull-right">(.*?)</span>.*</div>.*</div>#uis';
        // 全局匹配
        preg_match_all($course_body, $this->content, $matches, PREG_SET_ORDER);
        print_r($matches) ;die;
        $data = [];
        foreach ($matches as $key => $value) {
            $data[$key]['cname'] = $value[1];
            $data[$key]['cdesc'] = str_replace(array("\r", "\n", "\t", "\s", "<br>", " "), "", $value[2]);
            $data[$key]['ctype'] = $this->parseType($value[3]);
            $data[$key]['nlong'] = $this->titleIsLong($value[1]);
        }

        $this->data = $data;

    }

    public function parseContent()
    {
        echo "开始解析内容...\n";

        $this->parseCourseBody();

        echo "解析内容结束! \n";

        print_r($this->data);
//        $this->saveData();

    }

    // 存入数据库
//    public function saveData()
//    {
//        echo "正在存入数据库...\n";
//
//        $db =  new SQLite3('test.db');
//
//        $template = "insert into `course_data` (`cname`,`cdesc`,`ctype`,`nlong`)values('%s','%s','%s','%s')";
//        foreach ($this->data as $v) {
//            extract($v);
//            $sql = sprintf($template, $cname, $cdesc, $ctype, $nlong);
//
//            $ret = $db->exec($sql);
//        }
//
//        $db->close();
//
//        echo "入库完成 ！\n";
//    }


    // 解析课程类型
    public function parseType($str)
    {
        // 不执行执行匹配，只匹配第二个span中间内容
        $reg = '/<span[^>]*class="course-[^>]*>(.*?)<\/span>/';
        preg_match($reg, $str, $ctype);
        // 设置免费默认类型
        return empty($ctype) ? "免费" : $ctype[1];
    }

    // 判断课程名是否超长
    public function titleIsLong($str)
    {
        $i = 0;
        $count = 0;
        // strlen默认会将中文字符当作两个字符
        $len = strlen($str);
        while ($i < $len) {
            $chr = ord($str[$i]);
            $count++;
            $i++;
            if ($i >= $len) {
                break;
            }
            if ($chr & 0x80) {
                $chr <<= 1;
                while ($chr & 0x80) {
                    $i++;
                    $chr <<= 1;
                }
            }
        }

        return $count > 16 ? "true" : "false";
    }



    public function contactAction() {
        return TRUE;
    }

    public function featuresAction() {
        return TRUE;
    }

    public function pricingAction() {
        return TRUE;
    }
    public function tourAction() {
        return TRUE;
    }


}
