<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ref, toRef } from 'vue';
//import { toast } from 'vue-sonner';

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
import produtos from '@/routes/produtos';

export interface Produto {
    id?: number;
    nome: string;
    preco: string;
}

const props = defineProps<{
    produto?: Produto | null;
}>();

// Mantém reatividade do prop produto
const produto = toRef(props, 'produto');

// 🔑 controla abertura do modal
const open = ref(false);

// inicializa o form com o nome do produto (se existir)
const form = useForm({
    nome: produto.value?.nome ?? '',
    preco: produto.value?.preco ?? '',
});

/* function submit() {
    if (!produto.value) {
        form.post(produtos.criar().url, {
            onSuccess: () => {
                toast.success('Produto criado com sucesso!');
                open.value = false;
            },
            onError: () => {
                toast.error('Erro ao criar produto.');
            },
        });
    } else {
        form.put(produtos.update(produto.value!.id!).url, {
            onSuccess: () => {
                toast.success('Produto atualizado com sucesso!');
                open.value = false;
            },
            onError: () => {
                toast.error('Erro ao atualizar produto.');
            },
        });
    }
} */
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger>
            <Button class="bg-white hover:bg-white/90">
                <span> + Criar Novo Produto </span>
                <!-- <span v-else> Editar Produto</span> -->
            </Button>
        </DialogTrigger>
        <DialogContent>
            <!-- <Form @submit.prevent="submit"> -->
            <Form>
                <div class="grid-cols-1 md:grid-cols-2">
                    <Heading :title=" !produto ? 'Novo produto' : 'Editar Produto'" />
                    <div class="grid-cols-1 md:grid-cols-2">
                        <div class="grid gap-2">
                            <Label for="nome">Nome</Label>
                            <Input
                                v-model="form.nome"
                                id="nome"
                                type="text"
                                :tabindex="1"
                                autocomplete="nome"
                                name="nome"
                                placeholder="Nome produto"
                            />
                            <InputError :message="form.errors.nome" />
                        </div>

                        <div class="mt-10 grid gap-2">
                            <Label for="nome">Preço</Label>
                            <Input
                                v-model="form.preco"
                                id="preco"
                                type="text"
                                :tabindex="1"
                                autocomplete="preco"
                                name="preco"
                                placeholder="Preco produto"
                            />
                            <InputError :message="form.errors.preco" />
                        </div>

                        <div class="mt-4 flex justify-end gap-2">
                            <Button
                                type="submit"
                                class="mt-2 bg-green-400 hover:bg-green-400/90"
                                tabindex="5"
                                data-test="register-user-button"
                            >
                                Criar
                            </Button>
                            <DialogClose as-child>
                                <Button
                                    type="button"
                                    class="mt-2"
                                    tabindex="5"
                                    data-test="register-user-button"
                                >
                                    Cancelar
                                </Button>
                            </DialogClose>
                        </div>
                    </div>
                </div>
            </Form>
        </DialogContent>
    </Dialog>
</template>

<style scoped></style>