function like(post_id) {
    var Data = new FormData();
    Data.append('post_id', post_id)
    fetch('include/like.php', {
        method: 'post',
        body: Data
    }).then(function (response) {
        return response.json();
    }).then(function (text) {
        document.getElementById("like_" + post_id).innerHTML = text.num;
        if (text.like == "unlike") {
            document.getElementById("btn_like" + post_id).innerHTML = "ถูกใจ";
        } else if (text.like == "like") {
            document.getElementById("btn_like" + post_id).innerHTML = "ยกเลิกถูกใจ";
        }
    }).catch(function (error) {
        alert(error);
    });
}
focusMethod = function getFocus(input_comment) {
    document.getElementById("input_comment" + input_comment).focus();
}
function comment(event, post_id) {
    event.preventDefault();
    var Data = new FormData(document.getElementById("comment" + post_id));
    fetch('include/comment.php', {
        method: 'post',
        body: Data
    }).then(function (response) {
        return response.text()
    }).then(function (text) {
        var comment = document.getElementById("comment_" + post_id).innerHTML
        document.getElementById("comment_" + post_id).innerHTML = comment + text
        document.getElementById("input_comment" + post_id).value = null;
    }).catch(function (error) {
        alert(error);
    });
}
function delete_post(post_id) {
    if (confirm("ยืนยันกา่รลบโพส")) {
        var Data = new FormData()
        Data.append('post_id', post_id)
        fetch('include/delete_post.php', {
            method: 'post',
            body: Data
        }).then(function (response) {
            return response.text()
        }).then(function (text) {
            if (text == "susses") {
                location.reload()
            } else if (text == "error") {
                alert("ลบไม่สำเร็จ");
            }
        }).catch(function (error) {
            alert(error);
        });
    }
}

function cancel_add(friend_id) {
    if(!confirm("ยืนยันการยกเลิกคำขอเป็นเพื่อน")){
        return
    }
    var Data = new FormData()
    Data.append('friend_id', friend_id)
    Data.append('cancel_add', 1)
    fetch('include/friend.php', {
        method: 'post',
        body: Data
    }).then(function (response) {
        return response.text()
    }).then(function (text) {
        if(text == "success"){
            location.reload();
        }else if(text == "error"){
            alert('ไม่สำเร็จ')
        }
    }).catch(function (error) {
        alert(error);
    });
}

function confirm_add(friend_id) {
    var Data = new FormData()
    Data.append('friend_id', friend_id)
    Data.append('confirm_add', 1)
    fetch('include/friend.php', {
        method: 'post',
        body: Data
    }).then(function (response) {
        return response.text()
    }).then(function (text) {
        if(text == "success"){
            location.reload();
        }else if(text == "error"){
            alert('ไม่สำเร็จ')
        }
    }).catch(function (error) {
        alert(error);
    });
}

function delete_add(friend_id) {
    if(!confirm("ยืนยันลบคำขอเป็นเพื่อน")){
        return
    }
    var Data = new FormData()
    Data.append('friend_id', friend_id)
    Data.append('delete_add', 1)
    fetch('include/friend.php', {
        method: 'post',
        body: Data
    }).then(function (response) {
        return response.text()
    }).then(function (text) {
        if(text == "success"){
            location.reload();
        }else if(text == "error"){
            alert('ไม่สำเร็จ')
        }
    }).catch(function (error) {
        alert(error);
    });
}

function cancel_friend(friend_id) {
    if(!confirm("ยืนยันการเลิกเป็นเพื่อน")){
        return
    }
    var Data = new FormData()
    Data.append('friend_id', friend_id)
    Data.append('cancel_friend', 1)
    fetch('include/friend.php', {
        method: 'post',
        body: Data
    }).then(function (response) {
        return response.text()
    }).then(function (text) {
        if(text == "success"){
            location.reload();
        }else if(text == "error"){
            alert('ไม่สำเร็จ')
        }
    }).catch(function (error) {
        alert(error);
    });
}

function add_friend(user_id) {
    var Data = new FormData()
    Data.append('user_id', user_id)
    Data.append('add_friend', 1)
    fetch('include/friend.php', {
        method: 'post',
        body: Data
    }).then(function (response) {
        return response.text()
    }).then(function (text) {
        if(text == "success"){
            location.reload();
        }else if(text == "error"){
            alert('ไม่สำเร็จ')
        }
    }).catch(function (error) {
        alert(error);
    });
}
document.getElementById('btn_profile').addEventListener('click', () => {
    document.getElementById('img_profile').click()
})
document.getElementById('img_profile').addEventListener('change', () => {
    var Data = new FormData()
    Data.append('edit_profile', document.getElementById('img_profile').files[0])
    fetch('include/img_profile.php', {
        method: 'post',
        body: Data
    }).then(function (response) {
        return response.text()
    }).then(function (text) {
        if(text == "success"){
            location.reload()
        }else if(text == "error"){
            alert("เปลี่นรูปไม่สำเร็จ");
        }
    }).catch(function (error) {
        alert(error);
    });
})