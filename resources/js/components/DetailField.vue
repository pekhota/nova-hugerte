<template>
  <PanelItem :index="index" :field="field">
    <template #value>
<!--      <excerpt :content="field.value" :should-show="field.shouldShow" />-->
      <excerpt :content="field.value" :should-show="true" />
    </template>
    </PanelItem>
</template>

<script>
export default {
  props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],

  data () {
    return {
      content: 'Hidden content'
    }
  }
}
</script>
