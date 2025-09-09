<template>

    <div class="video-section">
        <h2 class="font-bold">🎥 Watch Mr Beast Videos</h2>
        <div class="videos">
            <div v-for="video in videos" :key="video.id" class="video">
                <iframe
                    width="560"
                    height="315"
                    :src="`https://www.youtube.com/embed/${video.id}`"
                    :title="video.title"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
                </iframe>
<!--                "`https://www.youtube-nocookie.com/embed/${video.id}`"-->
            </div>
        </div>
    </div>
</template>

<script>


export default {
    name: 'VideosTutor',
    props: {
        routes: Object
    },
    data() {
        return {
            videos: [
                // https://youtu.be/XEEcxYzNOfI?si=HOyKec5_kCK5p_Sm
                { id: 'jaRfBM7ESfc?si=Bu8mZgEkmIJC5Wp8', title: 'Video 1' },
                { id: 'qBu08O4QEP8?si=-4qsrVaKVz2u-qCj', title: 'Video 2' },
                { id: 'Hwybp38GnZw?si=6P4eK_ji3cDsDoGJ', title: 'Video 3' },
                { id: 'fRIXxo5wpbg?si=NL3Hu3l-BObggdyD', title: 'Video 4' }
                // { id: 'W0iQguIT_yE?si=NL3Hu3l-BObggdyD', title: 'Video 4' }
            ]
        };
    }
};
</script>

<style scoped>
.video-section {
    text-align: center;
    margin: 50px 0;
}

.video-section h2 {
    font-size: 24px;
    margin-bottom: 20px;
}

.videos {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 20px;
}

iframe {
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Responsive styles for smaller screens */
@media (max-width: 768px) {
    .video-section h2 {
        font-size: 20px; /* Adjust heading size for smaller screens */
    }

    .videos {
        gap: 10px; /* Reduce the gap between videos */
    }

    iframe {
        width: 100%;
        max-width: 100%; /* Make sure iframe doesn't exceed container size */
        height: 180px; /* Adjust height for smaller screens */
    }
}
</style>
