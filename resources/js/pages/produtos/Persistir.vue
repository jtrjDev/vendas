<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';

const form = useForm({
    nome: '',
    valor: '',
});

const submit = () => {
    form.post(route('produtos.create'));
};
</script>

<template>
    <Head title="Cadastrar Produto" />

    <AppLayout>
        <div class="flex flex-col gap-4 p-4">
            <Heading
                title="Cadastrar Produto"
                description="Informe os dados do produto"
            />

            <form
                @submit.prevent="submit"
                class="max-w-xl rounded-xl border p-4"
            >
                <!-- NOME -->
                <div class="mb-4 grid gap-2">
                    <Label for="nome">Nome</Label>
                    <Input
                        id="nome"
                        v-model="form.nome"
                        type="text"
                        placeholder="Nome do produto"
                    />
                    <InputError :message="form.errors.nome" />
                </div>

                <!-- VALOR -->
                <div class="mb-4 grid gap-2">
                    <Label for="valor">Valor</Label>
                    <Input
                        id="valor"
                        v-model="form.valor"
                        type="text"
                        placeholder="0.00"
                    />
                    <InputError :message="form.errors.valor" />
                </div>

                <Button type="submit" :disabled="form.processing">
                    Salvar Produto
                </Button>
            </form>
        </div>
    </AppLayout>
</template>
