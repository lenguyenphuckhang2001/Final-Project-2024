function scrollBottomMsg() {
    $(".chatbox_field").scrollTop($(".chatbox_field").prop("scrollHeight"));
}

window.Echo.private("message." + USER_PROFILE.id).listen(
    "LiveMessage",
    (event) => {
        console.log(event);
        var textMessage = `
        <div class="tf__chating">
            <div class="tf__chating_img">
                <img class="img-fluid rounded-circle w-100" src="${event.user.avatar}" alt="person" >
            </div>
            <div class="tf__chating_text">
                <p>${event.message}</p>
            </div>
        </div>`;
        $(".chatbox_field").append(textMessage);
        scrollBottomMsg();
    }
);
