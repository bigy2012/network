function allow(user_id){
    var Data = new FormData();
    Data.append('user_id', user_id)
    Data.append('allow', 1)
    fetch('include/user.php', {
        method: 'post',
        body: Data
    }).then(function (response) {
        return response.text();
    }).then(function (text) {
        if(text == "success"){
            location.reload()
        }else if(text == "error"){
            alert("อนุญาติไม่สำเร็จ");
        }
    }).catch(function (error) {
        alert(error);
    });
}
function not_allow(user_id){
    if(!confirm("ยืนยันไม่อนุญาติ")){
        return
    }
    var Data = new FormData();
    Data.append('user_id', user_id)
    Data.append('not_allow', 1)
    fetch('include/user.php', {
        method: 'post',
        body: Data
    }).then(function (response) {
        return response.text();
    }).then(function (text) {
        if(text == "success"){
            location.reload()
        }else if(text == "error"){
            alert("ไม่อนุญาติไม่สำเร็จ");
        }
    }).catch(function (error) {
        alert(error);
    });
}
function enable(user_id){
    if(!confirm("ยืนยันเปิดการใช้งานสำเร็จ")){
        return
    }
    var Data = new FormData();
    Data.append('user_id', user_id)
    Data.append('enable', 1)
    fetch('include/user.php', {
        method: 'post',
        body: Data
    }).then(function (response) {
        return response.text();
    }).then(function (text) {
        if(text == "success"){
            location.reload()
        }else if(text == "error"){
            alert("เปิดการใช้งานไม่สำเร็จ");
        }
    }).catch(function (error) {
        alert(error);
    });
}
function disable(user_id){
    if(!confirm("ยืนยันปิดการใช้งานสำเร็จ")){
        return
    }
    var Data = new FormData();
    Data.append('user_id', user_id)
    Data.append('disable', 1)
    fetch('include/user.php', {
        method: 'post',
        body: Data
    }).then(function (response) {
        return response.text();
    }).then(function (text) {
        if(text == "success"){
            location.reload()
        }else if(text == "error"){
            alert("ปิดการใช้งานไม่สำเร็จ");
        }
    }).catch(function (error) {
        alert(error);
    });
}
function delete_post(post_id){
    if(!confirm("ยืนยันการลบโพส")){
        return
    }
    var Data = new FormData();
    Data.append('post_id', post_id)
    Data.append('delete_post', 1)
    fetch('include/post.php', {
        method: 'post',
        body: Data
    }).then(function (response) {
        return response.text();
    }).then(function (text) {
        if(text == "success"){
            location.reload()
        }else if(text == "error"){
            alert("ลบโพสไม่สำเร็จ");
        }
    }).catch(function (error) {
        alert(error);
    });
}