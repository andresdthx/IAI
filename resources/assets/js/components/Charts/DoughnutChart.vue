<script>

import { Doughnut, mixins } from 'vue-chartjs'
const { reactiveProp } = mixins;

export default {
  props: ['options'],
  extends: Doughnut,
  mixins: [reactiveProp],
  mounted () {
    this.renderChart(this.chartData, this.options)
  }
}
  
</script>
