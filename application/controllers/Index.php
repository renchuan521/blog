<?php


class IndexController extends BaseController {

    public function init() {
       

    }





    public function indexAction() {

        echo "��ʼ��ȡ����...\n";
        $this->loadFile('shiyanlou.html');
        $this->parseContent();
        return false;
    }

    private $content;
    private $data;
    private static $mysql;


    public function loadFile($file_path)
    {
        echo "���ڼ����ļ�...\n";
        $this->content = file_get_contents('http://labfile.oss.aliyuncs.com/contestlou5/shiyanlou.html');
    }

    public function parseCourseBody()
    {

        $subject = "1a23b";
         preg_match('/[\w]{2}/is', $subject,$a);
        var_dump($a);
        $a = preg_split('/([\d])/', $subject, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        var_dump($a);die;
        // s���η���.���ִ�п�ƥ�任��
        $course_body = '#<div class="course-body">.*<div class="course-name">(.*?)</div>.*<div class="course-desc">(.*?)</div>
        	.*<span class="course-bootcamp pull-right">(.*?)</span>.*</div>.*</div>#uis';
        // ȫ��ƥ��
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
        echo "��ʼ��������...\n";

        $this->parseCourseBody();

        echo "�������ݽ���! \n";

        print_r($this->data);
//        $this->saveData();

    }

    // �������ݿ�
//    public function saveData()
//    {
//        echo "���ڴ������ݿ�...\n";
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
//        echo "������ ��\n";
//    }


    // �����γ�����
    public function parseType($str)
    {
        // ��ִ��ִ��ƥ�䣬ֻƥ��ڶ���span�м�����
        $reg = '/<span[^>]*class="course-[^>]*>(.*?)<\/span>/';
        preg_match($reg, $str, $ctype);
        // �������Ĭ������
        return empty($ctype) ? "���" : $ctype[1];
    }

    // �жϿγ����Ƿ񳬳�
    public function titleIsLong($str)
    {
        $i = 0;
        $count = 0;
        // strlenĬ�ϻὫ�����ַ����������ַ�
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
