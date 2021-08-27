index.template yada boardindex.template herhangi bir yere
[code]    require_once __DIR__."/huu_news_slider/huu_news_slider.php";
    huu_news_slider();[/code]
    
daha sonra github linkini indirerek kullandığınız tema dizinin içine atarak kullanabilirsiniz.

Jquery yoksa <!-- --> açmayı unutmayın.

https://github.com/CeeMoo/huu_news_slider

huu_news_slider($bolumler = array(1), $kisa=255, $limit = 10)
array(1,3,5) gibi bölüm idleri yazarak kategorileri çekebilirsiniz.
$kisa= 255 ile çekilen konuları yazı olarak limitleyebilirsiniz.
$limit=10 ile 10 tane veri çekicektir.Yükseltip veya azaltıp kullanabilirsiniz.