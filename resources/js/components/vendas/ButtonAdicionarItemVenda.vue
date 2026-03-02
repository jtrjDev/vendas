<script setup lang="ts">
import { ref } from 'vue'

import {
  Dialog,
  DialogContent,
  DialogTrigger,
  DialogClose,
} from '@/components/ui/dialog'

import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'

import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import Heading from '@/components/Heading.vue'

const props = defineProps<{
  produtos: Array<{
    id: number
    nome: string
    valor: number
  }>
}>()

const emit = defineEmits(['adicionar'])

const open = ref(false)

const produtoSelecionado = ref<number | null>(null)
const quantidade = ref<number>(1)
const valor = ref<number | null>(null)

function adicionarItem() {
  if (!produtoSelecionado.value || !quantidade.value) return

  emit('adicionar', {
    produto_id: produtoSelecionado.value,
    quantidade: quantidade.value,
    valor: valor.value,
  })

  resetar()
}

function resetar() {
  produtoSelecionado.value = null
  quantidade.value = 1
  valor.value = null
  open.value = false
}
</script>

<template>
  <Dialog v-model:open="open">
    <DialogTrigger as-child>
      <Button type="button">
        Adicionar itens
      </Button>
    </DialogTrigger>

    <DialogContent class="sm:max-w-lg">
      <Heading title="Adicionar Item na Venda" />

      <!-- PRODUTO -->
      <div class="mt-4 flex flex-col gap-1">
        <Label>Produto</Label>
        <Select v-model="produtoSelecionado">
          <SelectTrigger>
            <SelectValue placeholder="Selecione o produto" />
          </SelectTrigger>

          <SelectContent>
            <SelectItem
              v-for="produto in produtos"
              :key="produto.id"
              :value="produto.id"
            >
              {{ produto.nome }}
            </SelectItem>
          </SelectContent>
        </Select>
      </div>

      <!-- QUANTIDADE -->
      <div class="mt-4 flex flex-col gap-1">
        <Label>Quantidade</Label>
        <Input
          type="number"
          v-model="quantidade"
          min="1"
        />
      </div>

      <!-- VALOR -->
      <div class="mt-4 flex flex-col gap-1">
        <Label>Valor</Label>
        <Input
          type="number"
          step="0.01"
          v-model="valor"
        />
      </div>

      <!-- AÇÕES -->
      <div class="mt-6 flex justify-end gap-2">
        <Button
          type="button"
          class="bg-green-400 hover:bg-green-400/90"
          @click="adicionarItem"
        >
          Adicionar
        </Button>

        <DialogClose as-child>
          <Button type="button" @click="resetar">
            Cancelar
          </Button>
        </DialogClose>
      </div>
    </DialogContent>
  </Dialog>
</template>