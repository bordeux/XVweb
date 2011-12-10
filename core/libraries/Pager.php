<?php

//pobrane z http://xoops.svn.sourceforge.net/
function pager($rpp, $count, $href, $opts=0) {
    $pages = ceil($count / $rpp);

    if (!$opts)
        $pagedefault = 0;
    else {
        $pagedefault = floor(($count - 1) / $rpp);
        if ($pagedefault < 0)
            $pagedefault = 0;
    }
    if ($opts != 0) {
        $page = 0 + $opts;
        if ($page < 0)
            $page = $pagedefault;
    }
    else
        $page = $pagedefault;

    $pager = "";

    $mp = $pages - 1;
    $as = "<b>&lt;&lt;&nbsp;".$GLOBALS['Language']['Prev']."</b>";
    if ($page >= 1) {
        $pager .= "<a href=\"".str_replace("-npage-id-", ($page - 1), $href)."\">";
        $pager .= $as;
        $pager .= "</a>";
    }
    else
        $pager .= $as;
    $pager .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $as = "<b>".$GLOBALS['Language']['Next']."&nbsp;&gt;&gt;</b>";
    if ($page < $mp && $mp >= 0) {
        $pager .= "<a href=\"".str_replace("-npage-id-", ($page + 1), $href)."\">";
        $pager .= $as;
        $pager .= "</a>";
    }
    else
        $pager .= $as;

    if ($count) {
        $pagerarr = array();
        $dotted = 0;
        $dotspace = 3;
        $dotend = $pages - $dotspace;
        $curdotend = $page - $dotspace;
        $curdotstart = $page + $dotspace;
        for ($i = 0; $i < $pages; ++$i) {
            if (($i >= $dotspace && $i <= $curdotend) || ($i >= $curdotstart && $i < $dotend)) {
                if (!$dotted)
                    $pagerarr[] = "...";
                $dotted = 1;
                continue;
            }
            $dotted = 0;
            $start = $i * $rpp + 1;
            $end = $start + $rpp - 1;
            if ($end > $count)
                $end = $count;
            $text = "$start&nbsp;-&nbsp;$end";
            if ($i != $page)
                $pagerarr[] = "<a href=\"".str_replace("-npage-id-", $i, $href)."\"><b>$text</b></a>";
            else
                $pagerarr[] = "<b>$text</b>";
        }
        $pagerstr = join(" | ", $pagerarr);
        $pagertop = "<div style=\"text-align:center;\" class='xv-pager'>$pager<br />$pagerstr</div>\n";
        $pagerbottom = "<div style=\"text-align:center;\" class='xv-pager'>$pagerstr<br />$pager</div>\n";
    }
    else {
        $pagertop = "<div style=\"text-align:center;\" class='xv-pager'>$pager</div>\n";
        $pagerbottom = $pagertop;
    }

    $start = $page * $rpp;

    return array($pagertop, $pagerbottom);
}
?>