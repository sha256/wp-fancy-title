/*
Author: Shamim Hasnath
Author URI: http://hasnath.net
License: GPLv2
*/
function the_fancifier(attr, name, cls_tag_no, pre, post, line, len, first_run, start_again, speed) {
    
    if(attr == 'id')
        now = document.getElementById(name); 
    else if(attr == 'class')
         now = document.getElementsByClassName(name)[cls_tag_no];
    else if(attr == 'tag')
         now = document.getElementsByTagName(name)[cls_tag_no];
    
    if(first_run) {
        line = (attr == 'title' ? document.title : now.innerHTML);
        len = line.length;
       }
        var pipe = (post == len && start_again == false) // decide whether we need pipe
        if(attr == 'title')
            document.title = line.substring(pre, post) + (pipe == false ? " | " : "");
        else
            now.innerHTML = line.substring(0, post) + (pipe == false ? " | " : "");
         
         post == len ? new_speed = speed*7 : new_speed = speed; 
        if(post == len && start_again == false) return;
         post != len ? post++ : post = 0;       
         attr == 'title' && post > 45  ? pre++ : pre = 0 ;

        
        setTimeout(function() { 
                the_fancifier(attr, name, cls_tag_no,  pre, post, line, len, 0, start_again, speed);
            }, new_speed );
    
 
}
function fancyIt(attr, name, start_again, speed){
    return the_fancifier(attr, name, 0, 0, 0, '', 0, 1, start_again, speed);
}
function fancyClass(name, pos, start_again, speed){
    return the_fancifier('class', name, pos, 0, 0, '', 0, 1, start_again, speed);
}

function fancyTag(name, pos, start_again, speed){
    return the_fancifier('tag', name, pos, 0, 0, '', 0, 1, start_again, speed);
}

function fancyTitle(start_again, speed){
    return fancyIt('title', '', start_again, speed);
}


		