<?php
require('lib/getwhois.class.php');

class XMLWrite {
	
	// @todo clarify out $data
	
	function __construct($data) {
		$this->data = $data;
		$this->xml = new XmlWriterz();
		$i = '0';
		$this->whois = new IPData;
		$loc = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'];
		$loc = explode("featureDownload.php", $loc);
		$url = $loc['0'].'lib/1.1.1.xml';
		$reader = simplexml_load_file($url);
		foreach($reader->download as $d) {
			$this->number = $d->number;
		}
	}
	function body() {

		foreach ($this->data as $row) {
			$this->geoTag = $this->whois->locateIp($row['ip']);
			$this->number = $this->number + 1;
			$this->xml->push('download');
				$this->xml->element('ip', $row['ip']);
				$this->xml->element('date', date('c'));
				$this->xml->element('number', $this->number);
				$this->xml->element('agent', $row['agent']);
				$this->xml->element('location', $this->geoTag['city'] . ", " . $this->geoTag['region_name']);
					$this->xml->push('feature');
				$this->xml->element('name', $row['feature']['name']);
				$this->xml->pop();
				$i++;
		}
		$this->xml->pop();
	}
	function compile() {
		/*$this->xml->push('log');
		$this->xml->push('logInfo');
			$this->xml->element('version', '1.1.1');
			$this->xml->element('name', 'Tiger');
			$this->xml->element('releaseDate', 'October 1, 1960');
		$this->xml->pop();*/
		$this->body();
		return $this->xml->getXml();
	}
	function write() {
		$xml = $this->compile();
		
		$originalfile = file_get_contents ('logs/1.1.1.xml');
		$newFile = str_replace('</log>',$xml.'</log>',$originalfile);
		file_put_contents('logs/1.1.1.xml', $newFile);
		
	}
}

class XmlWriterz {
    var $xml;
    var $indent;
    var $stack = array();
    function XmlWriterz($indent = '    ') {
        $this->indent = $indent;
        /*$this->xml = '<?xml version="1.0" encoding="utf-8"?>'."\n";*/
    }
    function _indent() {
        for ($i = 0, $j = count($this->stack); $i < $j; $i++) {
            $this->xml .= $this->indent;
        }
    }
    function push($element, $attributes = array()) {
        $this->_indent();
        $this->xml .= '<'.$element;
        foreach ($attributes as $key => $value) {
            $this->xml .= ' '.$key.'="'.htmlentities($value).'"';
        }
        $this->xml .= ">\n";
        $this->stack[] = $element;
    }
    function element($element, $content, $attributes = array()) {
        $this->_indent();
        $this->xml .= '<'.$element;
        foreach ($attributes as $key => $value) {
            $this->xml .= ' '.$key.'="'.htmlentities($value).'"';
        }
        $this->xml .= '>'.htmlentities($content).'</'.$element.'>'."\n";
    }
    function emptyelement($element, $attributes = array()) {
        $this->_indent();
        $this->xml .= '<'.$element;
        foreach ($attributes as $key => $value) {
            $this->xml .= ' '.$key.'="'.htmlentities($value).'"';
        }
        $this->xml .= " />\n";
    }
    function pop() {
        $element = array_pop($this->stack);
        $this->_indent();
        $this->xml .= "</$element>\n";
    }
    function getXml() {
        return $this->xml;
    }
}

?>