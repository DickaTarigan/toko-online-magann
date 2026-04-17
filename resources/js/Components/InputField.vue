<script setup>
defineProps({
     label:       {type: String, required: true },
     modelValue:  {type: String, default: ''},
     type:        {type: String, default: ''},
     error:       {type: String, default: null},
     placeholder: {type: String, default: ''},
})
defineEmits(['update:modelValue']);
</script>

<template>
     <div class="mb-4">
          <label class="label">{{ label }}</label>
          <input
               :type="type"
               :value="modelValue"
               :placeholder="placeholder"
               class="input"
               :class="{'border-red-500 focus:ring-red-500': error }"
               @input="$emit('update:modelValue', $event.target.value)"
          />
          <p v-if="error" class="mt-1 text-sm text-red-600">{{ error }}</p>
     </div>
</template>