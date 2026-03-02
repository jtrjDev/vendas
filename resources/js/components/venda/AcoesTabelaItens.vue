<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { toast } from 'vue-sonner';

import Heading from '@/components/Heading.vue';
import Icon from '@/components/Icon.vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogTrigger,
} from '@/components/ui/dialog';
import vendas from '@/routes/vendas';

const props = defineProps<{
    item: Record<string, any>;
}>();

const item = props.item;
const open = ref(false);
const emit = defineEmits<{
    (e: 'remover-item-local', payload: any): void;
    (e: 'item-removido', payload: any): void;
}>();
function removeitem(id_item: any) {
    const idStr = String(id_item ?? '');
    if (idStr.includes('adicionado_')) {
        // item criado apenas no cliente — avisa o pai para remover do array local
        emit('remover-item-local', id_item);
        toast.success('Item removido localmente.');
        open.value = false;
        return;
    }
    router.delete(vendas.removeItem(id_item).url, {
        onSuccess: () => {
            toast.success('Item removido com sucesso!');
            emit('item-removido', id_item);
            open.value = false;
        },
        onError: (errors) => {
            toast.error('Erro ao remover o Item.');
            console.error(errors);
        },
    });
}
</script>

<template>
    <div class="flex gap-2">
        <Dialog v-model:open="open">
            <DialogTrigger as-child>
                <Button
                    class="bg-destructive text-white hover:bg-destructive/90"
                >
                    <Icon name="trash" />
                </Button>
            </DialogTrigger>
            <DialogContent>
                <div class="flex flex-col gap-4">
                    <Heading
                        :title="`Confirma a exclusao do item ${item.nome} ?`"
                    />
                    <div class="grid-cols-1 md:grid-cols-2">
                        <!-- Form fields for creating a new vendedor go here -->
                        <div class="mt-4 flex justify-end gap-2">
                            <Button
                                @click="removeitem(item.id ?? item.id_item)"
                                class="mt-2 bg-destructive text-white hover:bg-destructive/90"
                                tabindex="5"
                                data-test="register-user-button"
                            >
                                Confirmar
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
            </DialogContent>
        </Dialog>
    </div>
</template>

<style scoped></style>
