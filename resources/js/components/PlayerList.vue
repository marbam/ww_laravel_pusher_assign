<template>
    <div class="players">
        <h1>Players in game</h1>
        <div>
            <ul>
                <li v-if="!players.length" v-text="startLabel"></li>
                <li v-if="players.length" v-for="player in players" v-text="player"></li>
            </ul>
        </div>
    <button id="proceed_button" :data-players='players.length' :data-roles='roleCount'>Proceed</button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                players: [],
                startLabel: 'None',
                roleCount: 0,
            }
        },
        created() {
           axios.get("/get_players/"+gameId, [])
                .then(res => {
                    if (res.data.players.length ) {
                        this.players = res.data.players;
                    }
                    this.roleCount = res.data.roles;
                }).catch(err => {
                console.log(err)
            })

            window.Echo.channel('games').listen('PlayerCreated', e => {
                this.players.push(e.player.name);
            });
        }
    }
</script>
