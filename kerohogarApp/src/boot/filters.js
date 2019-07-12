export default async ({ Vue }) => {
    Vue.filter("addDotsToNumber", value => value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."))
}