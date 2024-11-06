function scrollBottomMsg() {
    $(".chat-content").scrollTop($(".chat-content").prop("scrollHeight"));
}

window.Echo.private("message." + USER_PROFILE.id).listen(
    "LiveMessage",
    (event) => {
        console.log(event);
        let textMessage = `
            <div class="chat-item chat-left">
                <img class='chat-profile' width="50" height="50" style="object-fit:cover"
                src="${event.user.avatar}">
                <div class="chat-details">
                    <div class="chat-text">${event.message}</div>
                </div>
            </div>`;
        $(".chat-content").append(textMessage);
        scrollBottomMsg();
    }
);
