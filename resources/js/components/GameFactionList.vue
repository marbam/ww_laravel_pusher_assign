<template>
    <div class="faction-div">
        <h1>Factions in game</h1>
        <div>
            <ul>
                <li v-for="faction in factions" v-text="faction"></li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                factions: []
            }
        },

        created() {
           axios.get('/factions_in_game/'+gameId, [])
                .then(res => {
                    if (res.data.length > 1) {
                        this.factions = res.data;
                    }
                }).catch(err => {
                console.log(err)
            })

            window.Echo.channel('updates').listen('GameUpdated', e => {
                if (e.state == 'add'){
                    this.factions.push(e.factionName);
                } else {
                    this.factions = this.factions.filter(faction => faction != e.factionName);
                }
            });
        }
    }
</script>
