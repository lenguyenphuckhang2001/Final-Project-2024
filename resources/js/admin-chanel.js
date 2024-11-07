function scrollBottomMsg() {
    $(".chat-content").scrollTop($(".chat-content").prop("scrollHeight"));
}

window.Echo.private("chat-messages." + USER_PROFILE.id).listen(
    "LiveMessage",
    (event) => {
        console.log(event);
        let listingChatBoxId = $(".chat-content").attr("data-listing-chatbox");
        let userChatBoxId = $(".chat-content").attr("data-user-chatbox");

        if (
            listingChatBoxId == event.listing_id &&
            userChatBoxId == event.user.id
        ) {
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

        $(".profile-box").each(function () {
            let userChatBoxId = $(this).data("sender-id");
            let listingChatBoxId = $(this).data("listing-id");

            if (
                userChatBoxId == event.user.id &&
                listingChatBoxId == event.listing_id
            ) {
                $(this).find(".profile-image").addClass("img-notify");
                $(this).find(".profile-title").css("font-weight", "bold");
            }
        });
    }
);

window.Echo.join("active-user")
    .here((users) => {
        $.each(users, function (i, user) {
            $(".profile-box").each(function () {
                let userChatBoxId = $(this).data("sender-id");

                if (userChatBoxId == user.id) {
                    $(this).find(".active-status").html(` 
                        <div class="text-small font-600-bold text-success">
                            <i class="fas fa-circle"></i>
                                Online
                        </div>`);
                }
            });
        });
    })
    .joining((user) => {
        $(".profile-box").each(function () {
            let userChatBoxId = $(this).data("sender-id");

            if (userChatBoxId == user.id) {
                $(this).find(".active-status").html(` 
                        <div class="text-small font-600-bold text-success">
                            <i class="fas fa-circle"></i>
                                Online
                        </div>`);
            }
        });
    })
    .leaving((user) => {
        $(".profile-box").each(function () {
            let userChatBoxId = $(this).data("sender-id");

            if (userChatBoxId == user.id) {
                $(this).find(".active-status").html(` 
                    <div class="text-small font-600-bold text-secondary">
                        <i class="fas fa-circle"></i>
                            Offline
                    </div>`);
            }
        });
    });
