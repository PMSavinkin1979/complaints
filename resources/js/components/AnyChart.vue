

<script>
     import {Doughnut} from 'vue-chartjs'

     export default {
         extends: Doughnut,
         props:{
             masiv:{
                 type: Array,
                 default: 1
             },
             headers:{
                 type: Array,
                 default: 2
             },
         },
         watch:{
             masiv(){
                 console.log('Из AnyChart')
                 //console.log(this.masiv)

                 this.renderChart({
                     datasets: [{
                         data: this.masiv,
                         title:{
                             display:true,
                             text: 'Затраты по видам ГС'
                         },
                         backgroundColor: [
                             'rgba(255, 99, 132, 1)',
                             'rgba(54, 162, 235, 1)',
                             'rgba(255, 206, 86, 1)',
                             'rgba(28, 255, 1, 255)',
                             'rgba(173, 0, 255, 255)',
                             'rgba(0, 255, 180, 255)',
                             'rgba(0, 32, 22, 255)',
                         ],
                         /*borderColor: [
                             'rgba(255, 99, 132, 1)',
                             'rgba(54, 162, 235, 1)',
                             'rgba(255, 206, 86, 1)',
                         ],*/
                         borderWidth: 1
                     }],
                     // These labels appear in the legend and in the tooltips when hovering different arcs
                     labels: this.headers,
                 })
             }
         },
         mounted () {
             // Overwriting base render method with actual data.
             this.renderChart({
                 datasets: [{
                     data: this.masiv,
                     backgroundColor: [
                         'rgba(255, 99, 132, 0.2)',
                         'rgba(54, 162, 235, 0.2)',
                         'rgba(255, 206, 86, 0.2)',
                     ],
                     borderColor: [
                         'rgba(255, 99, 132, 1)',
                         'rgba(54, 162, 235, 1)',
                         'rgba(255, 206, 86, 1)',
                     ],
                     borderWidth: 1
                 }],
                 // These labels appear in the legend and in the tooltips when hovering different arcs
                 labels: this.headers
             })

         },
         /*updated() {
             console.log(this.masiv)
             console.log('update')
         }*/
     }
</script>
