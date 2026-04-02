import '../css/field.css'

import IndexField from './components/IndexField.vue'
import DetailField from './components/DetailField.vue'
import FormField from './components/FormField.vue'

Nova.booting((app, store) => {
  app.component('index-nova-hugerte', IndexField)
  app.component('detail-nova-hugerte', DetailField)
  app.component('form-nova-hugerte', FormField)
})
