<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3'
import { toast } from 'vue-sonner'
import { computed } from 'vue'

import vendas from '@/routes/vendas'

import {
    Select,
    SelectContent,
    SelectValue,
    SelectItem,
    SelectTrigger,
} from '@/components/ui/select'

import Heading from '@/components/Heading.vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Separator } from '@/components/ui/separator'
import AppLayout from '@/layouts/AppLayout.vue'

const page = usePage()

const clientes = page.props.clientes as any[]
const vendedores = page.props.vendedores as any[]
const produtos = page.props.produtos as any[]

const form = useForm({
    id_cliente: null as number | null,
    id_vendedor: null as number | null,
    itens: [] as Array<{
        id_produto: number | null,
        valor: number
    }>
})

function adicionarItem() {
    form.itens.push({
        id_produto: null,
        valor: 0
    })
}

function removerItem(index: number) {
    form.itens.splice(index, 1)
}

const total = computed(() =>
    form.itens.reduce((acc, item) => acc + Number(item.valor || 0), 0)
)

function salvarVenda() {

    if (!form.id_cliente) {
        toast.error('Selecione um cliente')
        return
    }

    if (!form.id_vendedor) {
        toast.error('Selecione um vendedor')
        return
    }

    if (form.itens.length === 0) {
        toast.error('Adicione pelo menos um item')
        return
    }

    form.post(vendas.create().url, {
        onSuccess: () => {
            toast.success('Venda cadastrada com sucesso!')
            form.reset()
        },
        onError: () => {
            toast.error('Erro ao cadastrar venda!')
        }
    })
}
</script>

<template>
    <Head title="Vendas" />

    <AppLayout>
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <Heading title="Vendas" description="Realizar venda" />

            <div class="relative flex-1 rounded-xl border p-6">

                <!-- DADOS -->
                <Heading title="Dados da venda" />

                <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2">

                    <!-- CLIENTE -->
                    <div>
                        <Label>Cliente</Label>
                        <Select v-model="form.id_cliente">
                            <SelectTrigger>
                                <SelectValue placeholder="Selecione o cliente" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem
                                    v-for="cliente in clientes"
                                    :key="cliente.id"
                                    :value="cliente.id"
                                >
                                    {{ cliente.nome }}
                                </SelectItem>
                            </SelectContent>
                        </Select>

                        <p v-if="form.errors.id_cliente" class="text-sm text-red-500 mt-1">
                            {{ form.errors.id_cliente }}
                        </p>
                    </div>

                    <!-- VENDEDOR -->
                    <div>
                        <Label>Vendedor</Label>
                        <Select v-model="form.id_vendedor">
                            <SelectTrigger>
                                <SelectValue placeholder="Selecione o vendedor" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem
                                    v-for="vendedor in vendedores"
                                    :key="vendedor.id"
                                    :value="vendedor.id"
                                >
                                    {{ vendedor.user.name }}
                                </SelectItem>
                            </SelectContent>
                        </Select>

                        <p v-if="form.errors.id_vendedor" class="text-sm text-red-500 mt-1">
                            {{ form.errors.id_vendedor }}
                        </p>
                    </div>

                </div>

                <Separator class="my-10" />

                <!-- ITENS -->
                <Heading title="Itens da venda" />

                <div class="mt-6">
                    <Button type="button" @click="adicionarItem">
                        + Adicionar item
                    </Button>
                </div>

                <div class="mt-6 space-y-4">
                    <div
                        v-for="(item, index) in form.itens"
                        :key="index"
                        class="grid grid-cols-3 gap-4 border rounded-lg p-4"
                    >
                        <!-- Produto -->
                        <Select v-model="item.id_produto">
                            <SelectTrigger>
                                <SelectValue placeholder="Produto" />
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

                        <!-- Valor -->
                        <Input
                            type="number"
                            v-model="item.valor"
                            placeholder="Valor"
                        />

                        <!-- Remover -->
                        <Button
                            type="button"
                            variant="destructive"
                            @click="removerItem(index)"
                        >
                            Remover
                        </Button>
                    </div>
                </div>

                <!-- TOTAL -->
                <div class="mt-6 text-right text-lg font-semibold">
                    Total: R$ {{ total.toFixed(2) }}
                </div>

                <Separator class="my-10" />

                <!-- BOTÃO FINAL -->
                <div class="flex justify-center">
                    <Button
                        type="button"
                        @click="salvarVenda"
                        :disabled="form.processing"
                        class="bg-green-500 hover:bg-green-600"
                    >
                        <span v-if="form.processing">Salvando...</span>
                        <span v-else>Gravar venda</span>
                    </Button>
                </div>

            </div>
        </div>
    </AppLayout>
</template>