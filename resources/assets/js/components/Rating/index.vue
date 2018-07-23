<template>
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">Фильтры</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>User Country</label>
                            <select v-model="filters.byCountry">
                                <option value="0">All country</option>
                                <option
                                        v-for="(country,index) in countries"
                                        :key="index"
                                        :value="country.id">{{country.name}}
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>User Activity</label>
                            <select v-model="filters.byActive">
                                <option value="0">Все</option>
                                <option value="1">Не активные = 0</option>
                                <option value="2">Активные = 1</option>

                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Hr/>
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-header">
                        Рейтинг
                    </div>
                    <div class="card-body">
                        <div class="float-right">
                            max: {{maxRating}}
                            <br/>
                            Avg: {{avgRating}}
                            <Br/>
                            Users with max score: {{maxUsers}}
                        </div>

                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>name</th>
                                <th>check in date</th>
                                <th>ip</th>
                                <th>check in country</th>
                                <th>rating</th>
                                <th>user country</th>
                                <th>user active</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(row, index) in filteredRows" :key="index" :class="{max: row.rating==maxRating}">
                                <td>{{row.user.name}}</td>
                                <td>{{row.check_in}}</td>
                                <td>{{row.ip}}</td>
                                <td>{{row.country ? row.country.name : '-'}}</td>
                                <td>{{row.rating}}</td>
                                <td>{{row.user.country.name}}</td>
                                <td>{{row.user.is_active}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
    export default {
        computed: {
            maxRating: function () {
                return Math.max(0, Math.max(...this.getCurrentRates()));
            },
            avgRating: function () {

                let rates = this.getCurrentRates()
                if (rates.length === 0) return 0;

                let summ = rates.reduce((start, el) => start + el);
                return Math.round(summ / rates.length);

            },
            maxUsers: function () {
                let maxUsersArray = [];
                this.filteredRows.forEach((el) => {
                    if (el.rating == this.maxRating && maxUsersArray.indexOf(el.user.name) === -1) {
                        maxUsersArray.push(el.user.name);
                    }
                })
                return maxUsersArray
            },
            filteredRows: function () {
                return this.rows.filter((row) => {
                    if (this.filters.byActive > 0) {
                        if (row.user.is_active != (this.filters.byActive - 1)) {
                            return false;
                        }
                    }
                    if (this.filters.byCountry > 0) {
                        if (row.user.country.id != this.filters.byCountry) {
                            return false;
                        }
                    }
                    return true;
                })


            }
        },
        methods: {
            getCurrentRates: function () {
                return this.filteredRows.map((el) => el.rating);
            }
        },
        data() {
            return {
                filters: {
                    byActive: 0,
                    byCountry: 0,

                },
                countries: [],
                rows: [],
            }

        },
        mounted() {
            axios.get('/api/v1/countries').then((res) => this.countries = res.data.data);
            axios.get('/api/v1/rating').then((res) => this.rows = res.data.data);
        }
    }
</script>
<style scoped>
    .max td {
        background: #9dffaa;
    }
</style>