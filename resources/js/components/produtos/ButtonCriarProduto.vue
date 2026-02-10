<script setup lang="ts">
import { useForm, router } from '@inertiajs/vue3';
import { ref, watch, toRef } from 'vue';
import produtos from '@/routes/produtos';

import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogTrigger,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

// props
const props = defineProps<{
    produto: {
        id: number;
        nome: string;
        valor: number;
    } | null;
}>();

const emit = defineEmits(['fechar']);

const produto = toRef(props, 'produto');

// controle do modal
const open = ref(false);

// formulário
const form = useForm({
    nome: '',
    valor: '',
});

// quando clicar em editar, carrega dados e abre modal
watch(produto, (novoProduto) => {
    if (novoProduto) {
        form.nome = novoProduto.nome;
        form.valor = novoProduto.valor;
        open.value = true;
    }
});

// submit criar / editar
function submit() {
    if (produto.value) {
        // ✏️ editar
        form.put(produtos.update(produto.value.id).url, {
            preserveScroll: true,
            onSuccess: () => {
                fecharModal();
                router.reload({ only: ['produtos'] });
            },
        });
    } else {
        // ➕ criar
        form.post(produtos.create().url, {
            preserveScroll: true,
            onSuccess: () => {
                fecharModal();
                router.reload({ only: ['produtos'] });
            },
        });
    }
}

function fecharModal() {
    open.value = false;
    form.reset();
    emit('fechar');
}
</script>

<template>
    <Dialog v-model:open="open">
        <!-- botão criar -->
        <DialogTrigger>
            <Button class="bg-white hover:bg-white/90">
                + Criar Novo Produto
            </Button>
        </DialogTrigger>

        <!-- modal -->
        <DialogContent>
            <form @submit.prevent="submit">
                <Heading
                    :title="produto ? 'Editar Produto' : 'Novo Produto'"
                />

                <!-- nome -->
                <div class="mt-4 grid gap-2">
                    <Label for="nome">Nome</Label>
                    <Input
                        id="nome"
                        v-model="form.nome"
                        placeholder="Nome do produto"
                    />
                    <InputError :message="form.errors.nome" />
                </div>

                <!-- valor -->
                <div class="mt-4 grid gap-2">
                    <Label for="valor">Preço</Label>
                    <Input
                        id="valor"
                        v-model="form.valor"
                        placeholder="Preço do produto"
                    />
                    <InputError :message="form.errors.valor" />
                </div>

                <!-- ações -->
                <div class="mt-6 flex justify-end gap-2">
                    <Button
                        type="submit"
                        class="bg-green-400 hover:bg-green-400/90"
                        :disabled="form.processing"
                    >
                        {{ produto ? 'Salvar' : 'Criar' }}
                    </Button>

                    <DialogClose as-child>
                        <Button type="button" @click="fecharModal">
                            Cancelar
                        </Button>
                    </DialogClose>
                </div>
            </form>
        </DialogContent>
    </Dialog>
</template>
