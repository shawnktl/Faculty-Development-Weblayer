<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
header('Content-type:text/html; charset=utf-8');
$db=mysqli_connect("localhost","pengu17_penguooo","1APR5xY8e","pengu17_questions");
mysqli_set_charset($db,"utf8");
include('residentInfoHeader.php');


function curl_get_contents($url)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

//Enter your spreadsheet identifier here
$spreadsheetIdentifier='1x7pRMG70GwDIsbooye4GwPWEdwCbda7XSa2ZrD9vI_I';
//Enter your google API Key here
$key="";
$spreadsheetURL="https://sheets.googleapis.com/v4/spreadsheets/" . $spreadsheetIdentifier . "/values/Sheet1?alt=json&key=$key";
$spreadsheetJSON=curl_get_contents($spreadsheetURL);
$encodedSpreadsheet=json_decode($spreadsheetJSON);
$rows=$encodedSpreadsheet->values;






$topicLinks='';
foreach($uniqueTopicsArray as $uniqueTopic){
    $topicLinks.="<a href=\"residencyResearchList.php?postedTopic=$uniqueTopic\" target=\"_blank\"><button class=\"w3-btn w3-round w3-blue w3-hover-red topicSearch\">$uniqueTopic</button></a>";
}

$table='<table class="tablesorter"><thead><tr><th>Faculty Name</th><th>Resource</th><th>Attestation</th><th>Benefit Rating</th><th>Recommendation Rating</th><th>Feedback</th><th>Timestamp</th></tr></thead><tbody>';


$rowCounter=0;
    foreach($rows as $row){
        $rowCounter=$rowCounter+1;
        if($rowCounter>1){
        $Timestamp=$row[0];
        $Name=$row[1];
        $Resource=$row[2] . $row[3] . $row[4] . $row[5] . $row[6] . $row[7] . $row[8] . $row[9 ] . $row[10];
        $Attestation=$row[11];
        $Beneficial=$row[12];
        $Recommend=$row[13];
        $Feedback=$row[14];
        $table.="<tr><td>$Name</td>";
        $table.="<td>$Resource</td>";
        $table.="<td>$Attestation</td>";
        $table.="<td>$Beneficial</td>";
        $table.="<td>$Recommend</td>";
        $table.="<td>$Feedback</td>";
        $table.="<td>$Timestamp</td>";
        $table.="</tr>";
    }
    }

$table.="</tbody></table>";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>AUR Faculty Development Weblayer Demo</title>

    <!-- jQuery -->
    <!-- <script src="tablesorter-master/docs/js/jquery-latest.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="bootstrap.min.css">

    <!-- Demo stuff -->
    <link class="ui-theme" rel="stylesheet" href="tablesorter-master/docs/css/jquery-ui.min.css">
    <script src="tablesorter-master/docs/js/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="tablesorter-master/docs/css/jq.css">
    <link href="tablesorter-master/docs/css/prettify.css" rel="stylesheet">
    <script src="tablesorter-master/docs/js/prettify.js"></script>
    <script src="tablesorter-master/docs/js/docs.js"></script>

    <!-- Tablesorter: required -->
    <link rel="stylesheet" href="tablesorter-master/dist/css/theme.blue.css">
    <script src="tablesorter-master/dist/js/jquery.tablesorter.js"></script>
    <script src="tablesorter-master/js/widgets/widget-storage.js"></script>
    <script src="tablesorter-master/js/widgets/widget-scroller.js"></script>
    <script src="tablesorter-master/js/widgets/widget-filter.js"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <script id="js">
    function dbSearch(topic){
        // alert(topic);
        $('input[data-column="1"]').empty().val(topic);
        filter=[];
        col=1;
        filter[ col === 'all' ? totalColumns : col ] = topic;
        $table.trigger('search', [ filter ]);
    }

    $(function() {
    $(document).tooltip({
          content: function () {
              return $(this).prop('title');
          }
      })
    var $table = $('table').tablesorter({
        theme: 'blue',
        widgets: ["zebra", "filter","scroller"],
        widgetOptions : {
            // filter_anyMatch replaced! Instead use the filter_external option
            // Set to use a jQuery selector (or jQuery object) pointing to the
            // external filter (column specific or any match)
            scroller_height:800,
            scroller_barWidth:18,
            scroller_upAfterSort: true,
            scroller_jumpToHeader:false,
            scroller_idPrefix : 's_',
            filter_external : '.search',
            // add a default type search to the first name column
            filter_defaultFilter: { 1 : '~{query}' },
            // include column filters
            filter_columnFilters: true,
            filter_placeholder: { search : 'Search...' },
            filter_saveFilters : true,
            filter_reset: '.reset'
        }
    });

    // make demo search buttons work
    $('button[data-column]').on('click', function() {
        var $this = $(this),
            totalColumns = $table[0].config.columns,
            col = $this.data('column'), // zero-based index or "all"
            filter = [];

        // text to add to filter
        filter[ col === 'all' ? totalColumns : col ] = $this.text();
        $table.trigger('search', [ filter ]);
        return false;
    });
    $('.topicLinks').on('click', function() {
                col = '1', // zero-based index or "all"
        filter = [];

        // text to add to filter
        filter[ col === 'all' ? totalColumns : col ] = $this.text();
        $table.trigger('search', [ filter ]);
        return false;
    });

});</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-21245552-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-21245552-1');
</script>



</head>
<body style='background-color:grey'>


<?php echo($navBar);?>
<!-- <div id="main">

    <div id="header" style='display:inline-block;width:100%'>
    <div style='display:inline-block;width:78%;text-align:left'>
        <img src="DownstateLogo3.png"/>
    </div>
    <div style='display:inline-block;width:20%;text-align:right'>
        <a href="https://docs.google.com/forms/d/e/1FAIpQLSeH-sUWeh1wl4ab4DP48E96dJEo8XUvgKynVwqkcpjlrFVWmA/viewform" target="_blank"><button class="w3-btn w3-round w3-blue w3-hover-red">Submit information </button></a>
    </div>  
</div>
 -->

<div id="wrapper" style='text-align:center;padding:200px'>
<?php echo $table; ?>
</div>


</body>
</html>
