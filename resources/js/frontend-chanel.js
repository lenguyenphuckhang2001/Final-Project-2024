function scrollBottomMsg() {
    $(".chatbox_field").scrollTop($(".chatbox_field").prop("scrollHeight"));
}

window.Echo.private("message." + USER_PROFILE.id).listen(
    "LiveMessage",
    (event) => {
        console.log(event);
        let listingChatBoxId = $(".chatbox_field").attr("data-listing-chatbox");
        let userChatBoxId = $(".chatbox_field").attr("data-user-chatbox");

        if (
            listingChatBoxId == event.listing_id &&
            userChatBoxId == event.user.id
        ) {
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
    }
);
