// main loop
var offset_main = 8000;
var loop_main = false;
var count_main = 0;
// sub1 loop
var offset_sub1 = 1000;


var order_result = 0
var temp_counter = 0;
function main_scrap(data, offset){
    if(data['subject'] == "basketball"){
        scrap_schedule(data);
    }else if(data['subject'] == "football"){
        scrap_schedule(data);
    }else if(data['subject'] == "mlb"){
        scrap_schedule(data);
    }else if(data['subject'] == "nfl"){
        scrap_schedule(data);
    }else if(data['subject'] == "nba"){
        scrap_schedule(data);
    }else if(data['subject'] == "nhl"){
        scrap_schedule(data);
    }else if(data['subject'] == "mls"){
        scrap_schedule(data);
    }else if(data['subject'] == "nascar"){
        scrap_schedule(data);
    }else if(data['subject'] == "horse"){
        scrap_schedule(data);
    }
}
function scrap_schedule(data){
    var key1 = data['key1'];
    var key2 = data['key2'];
    var subject = data['subject'];
    var id = data['id'];
    var club = data['club'];
    $.post(
        "./parse.php",
        {
            key : "get_schedule",
            key1 : key1,
            key2 : key2,
            subject : subject,
            id : id,
            club : club
        },
        function(response){
//            console.log(response);
            if(response.length > 0 ){
                // get schedule
                for(var i = 0 ; i < response.length; i ++){
                    order_result ++;
                    var html = "<tr>";
                    html += "<td>"+ order_result +"</td>";
                    html += "<td>"+response[i].subject+"</td>";
                    html += "<td>"+timestampToDate(response[i].start)+"</td>";
                    html += "<td>"+timestampToDate(response[i].end)+"</td>";
                    html += "<td>"+response[i].home_team+"</td>";
                    html += "<td>"+response[i].away_team+"</td>";
                    html += "<td>"+response[i].is_save+"</td>";
                    html += "</tr>";
                    $(".result").append(html);
                }
            }

        },"json"
    );
}
function scrap_football(data){
    var key1 = data['key1'];
    var key2 = data['key2'];
    var subject = data['subject'];
    var id = data['id'];
    var club = data['club'];
    $.post(
        "./parse.php",
        {
            key : "get_schedule",
            key1 : key1,
            key2 : key2,
            subject : subject,
            id : id,
            club : club
        },
        function(response){
//            console.log(response);
            if(response.length > 0 ){
                // get schedule
                var loop_sub1 = false;
                var count_sub1 = 0;
                loop_sub1 = setInterval(function() {
                    if(response.length <= count_sub1 ){ clearInterval(loop_sub1);return;};
                    order_result ++;
                    var html = "<tr>";
                    html += "<td>"+ order_result +"</td>";
                    html += "<td>"+response[ count_sub1 ].gameId+"</td>";
                    html += "<td>"+"</td>";
                    html += "<td>"+"</td>";
                    html += "<td>"+"</td>";
                    html += "</tr>";
                    $(".result").append(html);
                    sub1_scrap(response[ count_sub1 ].gameId, subject, id, club, key1);
                    count_sub1 ++;
                }, offset_sub1);
            }

        },"json"
    );
}
function sub1_scrap(gameId, subject, id, club, key1){
    $.post(
        "./parse.php",
        {
            key : "get_event",
            key1 : key1,
            gameId : gameId,
            subject : subject,
            id : id,
            club : club
        },
        function(response){
            temp_counter ++;
            console.log(temp_counter);
        },"json"
    );
}
function timestampToDate(timestamp){
    var pubDate = new Date();
    pubDate.setTime(timestamp * 1000); //expects milliseconds

    var weekday=new Array("Sun","Mon","Tue","Wed","Thu","Fri","Sat");
    var monthname=new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
    var formattedDate = monthname[pubDate.getMonth()] +' '+ pubDate.getDate() + ', ' + pubDate.getFullYear();
    return formattedDate;
}
