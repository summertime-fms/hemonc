function findVideos() {
    let videos = document.querySelectorAll(".yt-video");

    for (let i = 0; i < videos.length; i++) {
        setupVideo(videos[i]);
    }
}

function setupVideo(video) {
    let link = video.querySelector(".yt-video__link");
    let media = video.querySelector(".yt-video__media");
    let button = video.querySelector(".yt-video__button");
    if (media) {
        let id = parseMediaURL(media);
        video.addEventListener("click", () => {
            let iframe = createIframe(id);
    
            link.remove();
            button.remove();
            video.appendChild(iframe);
        });
    
        link.removeAttribute("href");
        video.classList.add("video--enabled");
    }
}

function parseMediaURL(media) {
    return media.dataset.media;
}

function createIframe(id) {
    let iframe = document.createElement("iframe");

    iframe.setAttribute("allowfullscreen", "");
    iframe.setAttribute("allow", "autoplay");
    iframe.setAttribute("src", generateURL(id));
    iframe.classList.add("yt-video__media");

    return iframe;
}

function generateURL(id) {
    let query = "?rel=0&showinfo=0&autoplay=1";

    return "https://www.youtube.com/embed/" + id + query;
}

$(document).ready(function () {
    findVideos();
});