var options = {
    width: '100%',
    height: '100%',
    channel: "barbe___douce",
    layout: "video", //"video-with-chat"
};

var embed = new Twitch.Embed("twitchStreamEmbed", options);
var player;

const twitchStreamEmbed = document.getElementById("twitchStreamEmbed");
const twitchOnlineCircle = document.getElementById("twitchOnlineCircle");
const twitchOnlineText = document.getElementById("twitchOnlineText");

// Si le stream est prêt
embed.addEventListener(Twitch.Embed.VIDEO_READY, () => {

    // On get le Player, met le volume et lance
    player = embed.getPlayer();
    player.setVolume(1);
    player.setMuted(true);
    player.play();
});

// On check pour la fin du live ou le début (permet aussi d'initialiser le stream au lancement de la page)
embed.addEventListener(Twitch.Player.OFFLINE, HideStream);
embed.addEventListener(Twitch.Player.ONLINE, ShowStream);

// Stream OFF, on le cache pour afficher une image custom
function HideStream()
{
    // On cache le live embed
    twitchStreamEmbed.classList.add('opacity-0');
    twitchStreamEmbed.classList.remove('opacity-100');

    // Et on change nos textes et petit rond pour dire que le live est OFF
    twitchOnlineCircle.classList.add('bg-red-500');
    twitchOnlineCircle.classList.remove('bg-green-500');

    twitchOnlineText.textContent = 'OFF';
}

// Stream ON, on affiche le stream twitch, par dessus notre image custom
function ShowStream()
{
    // On affiche le live embed
    twitchStreamEmbed.classList.remove('opacity-0');
    twitchStreamEmbed.classList.add('opacity-100');

    // Et on change nos textes et petit rond pour dire que le live est ON
    twitchOnlineCircle.classList.remove('bg-red-500');
    twitchOnlineCircle.classList.add('bg-green-500');

    twitchOnlineText.textContent = 'ON';
}
