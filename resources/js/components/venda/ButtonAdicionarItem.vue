<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { now } from '@vueuse/core';
import { ref, toRef } from 'vue';

import Heading from '@/components/Heading.vue';
import Icon from '@/components/Icon.vue';
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
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';

const props = defineProps<{
    produto?: Record<any, any> | null;
}>();

const produto = toRef(props, 'produto');

const open = ref(false);

const form = useForm({
    id_produto: '',
    quantidade: '',
    valor: '',
});

const emit = defineEmits<{
    (
        e: 'adicionar-item',
        payload: {
            id_produto: string;
            quantidade: string;
            valor: string;
            nome: string;
            id_item?: string | null;
        },
    ): void;
}>();

function onValorInput(e: Event) {
    const el = e.target as HTMLInputElement;
    let v = el.value;

    // troca vírgula por ponto
    v = v.replace(',', '.');

    // remove qualquer coisa que não seja número ou ponto
    v = v.replace(/[^\d.]/g, '');

    // garante apenas UM ponto
    const firstDot = v.indexOf('.');
    if (firstDot !== -1) {
        v = v.slice(0, firstDot + 1) + v.slice(firstDot + 1).replace(/\./g, '');
    }

    // limita a 2 casas decimais
    if (v.includes('.')) {
        const [intPart, decPart] = v.split('.');
        v = intPart + '.' + decPart.slice(0, 2);
    }

    form.valor = v;
}

function onValorBlur() {
    if (!form.valor) return;

    let n = Number(form.valor.replace(',', '.'));

    if (isNaN(n)) {
        form.valor = '';
        return;
    }

    // sempre 2 casas decimais
    form.valor = n.toFixed(2);
}

// console.log(produto.value);
function onChangeProduto() {
    const selected =
        Array.isArray(produto.value) && produto.value.length
            ? produto.value.find((p: any) => String(p.id))
            : null;

    form.valor = selected?.preco ?? '';
}
function submit() {
    const selected =
        Array.isArray(produto.value) && produto.value.length
            ? produto.value.find(
                  (p: any) => String(p.id) === String(form.id_produto),
              )
            : null;

    emit('adicionar-item', {
        id_produto: form.id_produto,
        quantidade: form.quantidade,
        valor: form.valor,
        nome: selected?.nome ?? '',
        id_item: `adicionado_${now()}`,
    });

    form.reset('id_produto', 'quantidade', 'valor');
    open.value = false;
}
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <Button class="bg-accent hover:bg-accent/90">
                <Icon name="plus" />
                <span> Adicionar Itens </span>
            </Button>
        </DialogTrigger>

        <DialogContent>
            <div class="grid-cols-1 md:grid-cols-2">
                <Heading :title="'Adicionar Itens'" />
            </div>
            <div class="grid grid-cols-1 gap-2 md:grid-cols-1">
                <Label for="id_produto">Produto</Label>
                <Select v-model="form.id_produto">
                    <SelectTrigger class="w-full">
                        <SelectValue placeholder="Selecione um produto" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectLabel>Produtos</SelectLabel>
                        <SelectGroup>
                            <SelectItem
                                v-for="item in produto"
                                :key="item.id"
                                :value="item.id"
                                @select="onChangeProduto"
                            >
                                {{ item.nome }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <InputError :message="form.errors.id_produto" />
            </div>
            <div class="mt-2 grid grid-cols-1 gap-2 md:grid-cols-2">
                <div class="grid gap-2">
                    <Label for="nome">Quantidade</Label>
                    <Input
                        v-model="form.quantidade"
                        id="quantidade"
                        type="text"
                        autofocus
                        :tabindex="1"
                        autocomplete="quantidade"
                        name="quantidade"
                        placeholder="Informe a quantidade"
                    />
                    <InputError :message="form.errors.quantidade" />
                </div>

                <div class="grid gap-2">
                    <Label for="nome">Valor</Label>
                    <div class="relative">
                        <span
                            class="pointer-events-none absolute top-1/2 left-3 -translate-y-1/2 text-muted-foreground"
                        >
                            R$
                        </span>

                        <Input
                            v-model="form.valor"
                            id="valor"
                            type="text"
                            inputmode="decimal"
                            class="pl-10"
                            placeholder="0,00"
                            @input="onValorInput"
                            @blur="onValorBlur"
                        />
                    </div>
                    <InputError :message="form.errors.valor" />
                </div>
            </div>
            <div class="mt-4 flex justify-end gap-2">
                <Button
                    @click="submit"
                    class="hover:bg-success/90 mt-2 bg-save"
                    tabindex="5"
                    data-test="register-user-button"
                >
                    Adicionar
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
        </DialogContent>
    </Dialog>
</template>

<style scoped></style>
