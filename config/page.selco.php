<?php
# Selçuk Çelik
# Pagination Class
# selcuk@msn.com

class pagination{

	public $toplam;
	public $limit;
	public $scroll;
	public $style;
	public $request;
	public $previous_text;
	public $next_text;
	private $page_num;
	
    public function paginate(){
	
		$this->page_num = $_GET[$this->request];
		
		if($this->page_num == '' or !is_numeric($this->page_num) or !intval($this->page_num)){$this->page_num = 1;}
		
		$this->baslangic = ($this->page_num-1)*$this->limit;
		
		$this->ortalama = ceil($this->toplam/$this->limit);
		
		$this->query = $this->baslangic.",".$this->limit;
		
		if($this->page_num > $this->ortalama){$this->page_num = 1;}

		
		if($this->page_num > 1){$i_previous = '<li><a href="'.$this->page.''.$this->request.'=1">Ilk</a></li>';}
		if($this->page_num < $this->ortalama){$i_next = '<li><a href="'.$this->page.''.$this->request.'='.$this->ortalama.'">Son</a></li>';}
		if($this->page_num <= 1){$previous = '<li class="active"><a href="#" onclick="return false">'.$this->previous_text.'</a></li>';} else{$previous_a = $this->page_num-1; $previous = '<li><a href="'.$this->page.''.$this->request.'='.$previous_a.'">'.$this->previous_text.'</a></li>';}
		if($this->page_num == $this->ortalama){$next = '<li class="active"><a href="#" onclick="return false">'.$this->next_text.'</a></li>';} else{$next_a = $this->page_num+1; $next = '<li><a href="'.$this->page.''.$this->request.'='.$next_a.'">'.$this->next_text.'</a></li>';}
		
		$this->sayfala .= $ul_style;
		$this->sayfala .= $i_previous;
		$this->sayfala .= $previous;

		// Kaydirma Ayarlari
		$pn = ceil($this->page_num/$this->scroll);
		$scroll = $this->scroll*$pn;
		if($this->page_num <= $this->scroll){$count = 1;} else{$count = $pn*$this->scroll-$this->scroll+1;}
		if($scroll > $this->ortalama){$scroll = $this->ortalama;}
		
		for($i=$count; $i<=$scroll; $i++){
		if($this->page_num == $i){$secili = '<li class="active"><a href="#" onclick="return false">'.$i.'</a></li>';} else{$secili = '<li><a href="'.$this->page.''.$this->request.'='.$i.'">'.$i.'</a></li>';}
		$this->sayfala .= $secili;
		}
		
		$this->sayfala .= $next;
		$this->sayfala .= $i_next;
	
	
	}

}

?>