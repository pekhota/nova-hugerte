import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-nova-hugerte', IndexField)
  app.component('detail-nova-hugerte', DetailField)
  app.component('form-nova-hugerte', FormField)
})
